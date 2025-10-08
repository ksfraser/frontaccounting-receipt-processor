<?php

use PHPUnit\Framework\TestCase;
use App\Ocr\OcrService;
use App\Ocr\OcrProviderInterface;
use App\Utils\Errors\OcrError;

class OcrServiceTest extends TestCase
{
    private OcrProviderInterface $mockProvider;
    private OcrService $ocrService;

    protected function setUp(): void
    {
        $this->mockProvider = $this->createMock(OcrProviderInterface::class);
        $this->ocrService = new OcrService($this->mockProvider);

        // Create dummy files for testing
        touch('test.jpg');
        touch('test.pdf');
    }

    protected function tearDown(): void
    {
        // Clean up dummy files
        @unlink('test.jpg');
        @unlink('test.pdf');
    }

    public function testProcessReceiptWithImage(): void
    {
        $filePath = 'test.jpg';
        $this->mockProvider->method('recognize')->willReturn('Recognized text');

        $result = $this->ocrService->processReceipt($filePath);

        $this->assertEquals('Recognized text', $result);
    }

    public function testProcessReceiptWithPdf(): void
    {
        $filePath = 'test.pdf';
        $this->mockProvider->method('recognize')->willReturn('Recognized text');

        $result = $this->ocrService->processReceipt($filePath);

        $this->assertEquals('Recognized text', $result);
    }

    public function testProcessReceiptFileNotFound(): void
    {
        $this->expectException(OcrError::class);
        $this->expectExceptionMessage('File not found: missing.jpg');

        $this->ocrService->processReceipt('missing.jpg');
    }

    public function testProcessReceiptUnsupportedFileType(): void
    {
        $this->expectException(OcrError::class);
        $this->expectExceptionMessage('File not found');

        $this->ocrService->processReceipt('unsupported.txt');
    }
}
