<?php

namespace App\Ingestion;

use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class UploadHandler
{
    private OcrService $ocrService;
    private ReceiptParser $receiptParser;
    private FileSaver $fileSaver;
    private InvoiceProcessor $invoiceProcessor;

    public function __construct(
        OcrService $ocrService,
        ReceiptParser $receiptParser,
        FileSaver $fileSaver,
        InvoiceProcessor $invoiceProcessor
    ) {
        $this->ocrService = $ocrService;
        $this->receiptParser = $receiptParser;
        $this->fileSaver = $fileSaver;
        $this->invoiceProcessor = $invoiceProcessor;
    }

    public function handleUpload(UploadedFile $file): Response
    {
        try {
            $filePath = $this->fileSaver->saveFile($file);
            $text = $this->ocrService->processReceipt($filePath);
            $parsed = $this->receiptParser->parse($text);

            $invoicePayload = [
                'supplierId' => $parsed->supplier['id'],
                'items' => array_map(function ($item) {
                    return [
                        'itemId' => $item->description, // Using description as itemId for now
                        'quantity' => $item->quantity,
                        'price' => $item->unitPrice,
                    ];
                }, $parsed->items),
                'totalAmount' => $parsed->totalAmount,
                'date' => $parsed->date,
            ];

            $faResult = $this->invoiceProcessor->createInvoice($invoicePayload);
            $attachmentResult = $this->invoiceProcessor->attachFileToInvoice($faResult['id'] ?? null, $filePath);

            return new Response(json_encode([
                'message' => 'File processed and synced',
                'parsed' => $parsed,
                'faResult' => $faResult,
                'attachmentResult' => $attachmentResult,
            ]), Response::HTTP_OK, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return new Response(json_encode(['message' => $e->getMessage()]), Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
        }
    }
}
