<?php

namespace Tests\Ocr\Providers;

use App\Ocr\Providers\TesseractProvider;
use App\Utils\Errors\OcrError;
use PHPUnit\Framework\TestCase;

class TesseractProviderTest extends TestCase
{
    private TesseractProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new TesseractProvider();
    }

    public function testRecognizeImageSuccess(): void
    {
        $imagePath = __DIR__ . '/sample-image.png';
        touch($imagePath); // Create a dummy file for testing

        $result = $this->provider->recognizeImage($imagePath);

        $this->assertStringContainsString('Recognized text', $result);

        unlink($imagePath); // Clean up the dummy file
    }

    public function testRecognizeImageFileNotFound(): void
    {
        $this->expectException(OcrError::class);
        $this->expectExceptionMessage('File not found');

        $this->provider->recognizeImage('non-existent-file.png');
    }
}
