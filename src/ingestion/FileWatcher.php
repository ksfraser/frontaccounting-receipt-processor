<?php

namespace App\Ingestion;

use App\OCR\OcrService;
use App\OCR\OcrProviderInterface;
use App\Parsing\ReceiptParser;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class FileWatcher
{
    private ?Finder $watcher = null;
    private OcrService $ocr;
    private ReceiptParser $parser;
    private string $receiptsDir;

    public function __construct(OcrProviderInterface $provider)
    {
        $this->ocr = new OcrService($provider);
        $this->parser = new ReceiptParser();
        $this->receiptsDir = __DIR__ . '/../../receipts';

        // Ensure the directory exists
        if (!is_dir($this->receiptsDir)) {
            mkdir($this->receiptsDir, 0777, true);
        }
    }

    public function start(): void
    {
        if ($this->watcher !== null) {
            return; // already started
        }

        $this->watcher = new Finder();
        $this->watcher->files()->in($this->receiptsDir)->name('/\.(pdf|jpg|jpeg|png)$/i');

        foreach ($this->watcher as $file) {
            $this->processFile($file->getRealPath());
        }

        echo "Watching for new receipts in {$this->receiptsDir}\n";
    }

    private function processFile(string $filePath): void
    {
        echo "New receipt detected: {$filePath}\n";
        try {
            $text = $this->ocr->processReceipt($filePath);
            echo "OCR processed text: {$text}\n";
            $parsed = $this->parser->parse($text);
            echo "Parsed receipt: " . print_r($parsed, true) . "\n";
        } catch (\Exception $e) {
            echo "Failed to process new receipt: {$e->getMessage()}\n";
        }
    }
}

// Example usage
// $fileWatcher = new FileWatcher();
// $fileWatcher->start();
