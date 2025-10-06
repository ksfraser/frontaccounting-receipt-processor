<?php

namespace App\Ocr;

use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Utils\Errors\OcrError;

class TesseractProvider implements OcrProviderInterface
{
    public function recognize(string $filePath): string
    {
        try {
            $tesseract = new TesseractOCR($filePath);
            return $tesseract->lang('eng')->run();
        } catch (\Exception $e) {
            throw new OcrError("Tesseract OCR failed: {$e->getMessage()}");
        }
    }
}
