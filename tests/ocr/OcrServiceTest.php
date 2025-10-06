<?php

namespace Tests\Ocr;

use App\Ocr\OcrService;
use App\Ocr\OcrProviderInterface;
use App\Utils\Errors\OcrError;
use PHPUnit\Framework\TestCase;

class OcrServiceTest extends TestCase
{
    private OcrService $ocrService;
    private $mockProvider;

    protected function setUp(): void
    {
        $this->mockProvider = $this->createMock(OcrProviderInterface::class);
        $this->ocrService = new OcrService($this->mockProvider);
    }

    public function testProcessReceiptImage(): void
    {
        $this->mockProvider->method('recognize')->willReturn('Recognized text');

        $filePath = __DIR__ . '/sample-image.jpg';
        touch($filePath); // Create a dummy file for testing

        $result = $this->ocrService->processReceipt($filePath);

        $this->assertEquals('Recognized text', $result);

        unlink($filePath); // Clean up the dummy file
    }

    public function testProcessReceiptPdf(): void
    {
        $this->mockProvider->method('recognize')->willReturn('Recognized text');

        $filePath = __DIR__ . '/sample-file.pdf';
        touch($filePath); // Create a dummy file for testing

        $result = $this->ocrService->processReceipt($filePath);

        $this->assertEquals('Recognized text', $result);

        unlink($filePath); // Clean up the dummy file
    }

    public function testProcessReceiptFileNotFound(): void
    {
        $this->expectException(OcrError::class);
        $this->expectExceptionMessage('File not found');

        $this->ocrService->processReceipt('non-existent-file.jpg');
    }

    public function testProcessReceiptUnsupportedFileType(): void
    {
        $this->expectException(OcrError::class);
        $this->expectExceptionMessage('Unsupported file type');

        $filePath = __DIR__ . '/unsupported-file.txt';
        touch($filePath); // Create a dummy file for testing

        try {
            $this->ocrService->processReceipt($filePath);
        } finally {
            unlink($filePath); // Clean up the dummy file
        }
    }
}
