<?php

namespace Tests\Ingestion;

use App\Ingestion\UploadHandler;
use App\Ingestion\FileSaver;
use App\Ingestion\InvoiceProcessor;
use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use App\Parsing\ParsedReceipt;
use App\Parsing\ParsedItem;
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
    private $invoiceProcessorMock;
    private $uploadHandler;

    protected function setUp(): void
    {
        $this->fileSaverMock = $this->createMock(FileSaver::class);
        $this->ocrServiceMock = $this->createMock(OcrService::class);
        $this->receiptParserMock = $this->createMock(ReceiptParser::class);
        $this->invoiceProcessorMock = $this->createMock(InvoiceProcessor::class);

        $this->uploadHandler = new UploadHandler(
            $this->ocrServiceMock,
            $this->receiptParserMock,
            $this->fileSaverMock,
            $this->invoiceProcessorMock
        );
    }

    public function testHandleUploadSuccess(): void
    {
        $uploadedFile = $this->createMock(UploadedFile::class);
        $uploadedFile->method('getClientOriginalName')->willReturn('receipt.jpg');
        $uploadedFile->method('move')->willReturn(null);

        $this->ocrServiceMock->method('processReceipt')->willReturn('Sample OCR Text');
        $parsedReceipt = new ParsedReceipt(
            '2025-10-05',
            ['id' => 1, 'name' => 'Test Supplier'],
            [new ParsedItem('Test Item', 50.0, 2)],
            100.0
        );
        $this->receiptParserMock->method('parse')->willReturn($parsedReceipt);

        $this->fileSaverMock->method('saveFile')->willReturn('path/to/saved/file');

        $this->invoiceProcessorMock->method('createInvoice')->willReturn(['id' => 'invoice123']);
        $this->invoiceProcessorMock->method('attachFileToInvoice')->willReturn(['success' => true]);

        $response = $this->uploadHandler->handleUpload($uploadedFile);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('File processed and synced', $responseData['message']);
    }

    public function testHandleUploadFailure(): void
    {
        $uploadedFile = $this->createMock(UploadedFile::class);
        $uploadedFile->method('getClientOriginalName')->willReturn('receipt.jpg');

        $this->fileSaverMock->method('saveFile')->willThrowException(new \Exception('File save error'));

        $response = $this->uploadHandler->handleUpload($uploadedFile);

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('File save error', $responseData['message']);
    }
}
