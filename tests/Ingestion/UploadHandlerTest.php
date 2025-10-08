<?php

namespace Tests\Ingestion;

use App\Ingestion\UploadHandler;
use App\Ingestion\FileSaver;
use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use App\Integrations\FrontAccounting\FaClient;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class UploadHandlerTest extends TestCase
{
    private MockObject $fileSaverMock;
    private $ocrServiceMock;
    private $receiptParserMock;
    private $faClientMock;
    private $loggerMock;
    private $uploadHandler;

    protected function setUp(): void
    {
        $this->fileSaverMock = $this->createMock(FileSaver::class);
        $this->ocrServiceMock = $this->createMock(OcrService::class);
        $this->receiptParserMock = $this->createMock(ReceiptParser::class);
        $this->faClientMock = $this->createMock(FaClient::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->uploadHandler = new UploadHandler(
            $this->ocrServiceMock,
            $this->receiptParserMock,
            $this->faClientMock,
            $this->loggerMock,
            $this->fileSaverMock
        );
    }

    public function testHandleUploadSuccess(): void
    {
        $uploadedFile = $this->createMock(UploadedFile::class);
        $uploadedFile->method('getClientOriginalName')->willReturn('receipt.jpg');
        $uploadedFile->method('move')->willReturn(null);

        $this->ocrServiceMock->method('processReceipt')->willReturn('Sample OCR Text');
        $this->receiptParserMock->method('parse')->willReturn([
            'supplier' => ['id' => 1],
            'items' => [
                ['id' => 101, 'quantity' => 2, 'price' => 50.0],
            ],
            'totalAmount' => 100.0,
            'date' => '2025-10-05',
        ]);

        $this->faClientMock->method('createInvoice')->willReturn(['id' => 123]);
        $this->faClientMock->method('attachFileToInvoice')->willReturn(['status' => 'success']);

        $response = $this->uploadHandler->handleUpload($uploadedFile);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('File processed and synced', $responseData['message']);
    }

    public function testHandleUploadFailure(): void
    {
        $uploadedFile = $this->createMock(UploadedFile::class);
        $uploadedFile->method('getClientOriginalName')->willReturn('receipt.jpg');
        $uploadedFile->method('move')->willThrowException(new \Exception('File move error'));

        $this->loggerMock->expects($this->once())->method('error');

        $response = $this->uploadHandler->handleUpload($uploadedFile);

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('File move error', $responseData['message']);
    }
}
