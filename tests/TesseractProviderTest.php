<?php

use PHPUnit\Framework\TestCase;
use App\Ocr\Providers\TesseractProvider;
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
        $filePath = tempnam(sys_get_temp_dir(), 'test_image') . '.jpg';
        file_put_contents($filePath, 'dummy image content');

        // Mock the TesseractOCR library behavior
        $mockTesseract = $this->createMock(\thiagoalessio\TesseractOCR\TesseractOCR::class);
        $mockTesseract->method('run')->willReturn('Recognized text');

        // Inject the mock into the provider
        $this->tesseractProvider->setTesseractInstance($mockTesseract);

        $result = $this->tesseractProvider->recognizeImage($filePath);

        $this->assertEquals('Recognized text from ' . $filePath, $result);

        unlink($filePath);
    }

    public function testRecognizeThrowsOcrError(): void
    {
        $filePath = 'non-existent-file.jpg';

        $this->expectException(OcrError::class);
        $this->expectExceptionMessage('File not found: non-existent-file.jpg');

        $this->tesseractProvider->recognizeImage($filePath);
    }
}
