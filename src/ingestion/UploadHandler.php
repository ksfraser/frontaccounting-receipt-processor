<?php

namespace App\Ingestion;

use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use App\Integrations\FrontAccounting\FaClient;
use App\Utils\Errors\FileUploadError;
use App\Utils\Errors\ApiError;
use App\Utils\Errors\ParsingError;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class UploadHandler
{
    private OcrService $ocrService;
    private ReceiptParser $receiptParser;
    private FaClient $faClient;
    private LoggerInterface $logger;

    public function __construct(OcrService $ocrService, ReceiptParser $receiptParser, FaClient $faClient, LoggerInterface $logger)
    {
        $this->ocrService = $ocrService;
        $this->receiptParser = $receiptParser;
        $this->faClient = $faClient;
        $this->logger = $logger;
    }

    public function handleUpload(UploadedFile $file): Response
    {
        try {
            $filePath = $this->saveFile($file);
            $text = $this->ocrService->processReceipt($filePath);
            $parsed = $this->receiptParser->parse($text);

            $invoicePayload = [
                'supplierId' => $parsed['supplier']['id'],
                'items' => array_map(function ($item) {
                    return [
                        'itemId' => $item['id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ];
                }, $parsed['items']),
                'totalAmount' => $parsed['totalAmount'],
                'date' => $parsed['date'],
            ];

            $faResult = $this->faClient->createInvoice($invoicePayload);
            $attachmentResult = $this->attachFileToInvoice($faResult['id'] ?? null, $filePath);

            return new Response(json_encode([
                'message' => 'File processed and synced',
                'parsed' => $parsed,
                'faResult' => $faResult,
                'attachmentResult' => $attachmentResult,
            ]), Response::HTTP_OK, ['Content-Type' => 'application/json']);
        } catch (FileUploadError | ApiError | ParsingError $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            return new Response(json_encode(['message' => $e->getMessage()]), Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
        }
    }

    private function saveFile(UploadedFile $file): string
    {
        $uploadDir = __DIR__ . '/../../uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = $uploadDir . '/' . time() . '-' . $file->getClientOriginalName();
        $file->move($uploadDir, basename($filePath));

        return $filePath;
    }

    private function attachFileToInvoice(?string $invoiceId, string $filePath): ?array
    {
        if ($invoiceId === null) {
            return null;
        }

        try {
            return $this->faClient->attachFileToInvoice($invoiceId, $filePath);
        } catch (\Exception $e) {
            $this->logger->error('Failed to attach file to invoice', ['exception' => $e]);
            return ['error' => $e->getMessage()];
        }
    }
}
