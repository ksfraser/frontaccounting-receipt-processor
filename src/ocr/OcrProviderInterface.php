<?php

namespace App\Ocr;

interface OcrProviderInterface
{
    /**
     * Recognizes text from the given file.
     *
     * @param string $filePath Path to the file to process.
     * @return string Recognized text.
     */
    public function recognize(string $filePath): string;
}
