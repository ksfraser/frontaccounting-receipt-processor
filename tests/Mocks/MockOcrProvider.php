<?php

namespace Tests\Mocks;

use App\Ocr\OcrProviderInterface;

class MockOcrProvider implements OcrProviderInterface
{
    public function recognize(string $filePath): string
    {
        return "Mocked OCR text for {$filePath}";
    }
}
