<?php

namespace App\Ocr\Providers;

use App\Utils\Errors\OcrError;

class TesseractProvider
{
    private $tesseractInstance;

    public function setTesseractInstance($instance): void
    {
        $this->tesseractInstance = $instance;
    }

    public function recognizeImage(string $imagePath): string
    {
        try {
            // Simulate OCR processing using Tesseract (replace with actual implementation)
            if (!file_exists($imagePath)) {
                throw new OcrError("File not found: {$imagePath}");
            }

            // Dummy implementation for demonstration purposes
            return "Recognized text from {$imagePath}";
        } catch (\Exception $e) {
            throw new OcrError("Error recognizing image: " . $e->getMessage());
        }
    }
}
