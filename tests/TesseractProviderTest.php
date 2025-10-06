<?php

use PHPUnit\Framework\TestCase;
use App\Ocr\TesseractProvider;
use App\Utils\Errors\OcrError;

class TesseractProviderTest extends TestCase
{
    private TesseractProvider $tesseractProvider;

    protected function setUp(): void
    {
        $this->tesseractProvider = new TesseractProvider();
    }

    public function testRecognizeValidFile(): void
    {
        $filePath = 'valid-image.jpg';

        // Mock the TesseractOCR library behavior
        $mockTesseract = $this->createMock(\thiagoalessio\TesseractOCR\TesseractOCR::class);
        $mockTesseract->method('run')->willReturn('Recognized text');

        // Inject the mock into the provider
        $this->tesseractProvider->setTesseractInstance($mockTesseract);

        $result = $this->tesseractProvider->recognize($filePath);

        $this->assertEquals('Recognized text', $result);
    }

    public function testRecognizeThrowsOcrError(): void
    {
        $filePath = 'invalid-image.jpg';

        // Mock the TesseractOCR library to throw an exception
        $mockTesseract = $this->createMock(\thiagoalessio\TesseractOCR\TesseractOCR::class);
        $mockTesseract->method('run')->will($this->throwException(new \Exception('Tesseract error')));

        // Inject the mock into the provider
        $this->tesseractProvider->setTesseractInstance($mockTesseract);

        $this->expectException(OcrError::class);
        $this->expectExceptionMessage('Tesseract OCR failed: Tesseract error');

        $this->tesseractProvider->recognize($filePath);
    }
}
