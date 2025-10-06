<?php

namespace App\Ingestion;

use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use Symfony\Component\Finder\Finder;
use App\OCR\OcrProviderInterface;

class FileWatcher
{
    private ?Finder $finder = null;
    private OcrService $ocr;
    private ReceiptParser $parser;
    private string $receiptsDir;
    private OcrProviderInterface $ocrProvider;

    public function __construct(OcrProviderInterface $ocrProvider)
    {
        $this->ocrProvider = $ocrProvider;
        $this->ocr = new OcrService($ocrProvider);
        $this->parser = new ReceiptParser();
        $this->receiptsDir = __DIR__ . '/../../receipts';
    }

    public function start(): void
    {
        if ($this->finder !== null) {
            return; // already started
        }

        $this->finder = new Finder();
        $this->finder->files()->in($this->receiptsDir)->name('/\.(pdf|jpg|jpeg|png)$/i');

        foreach ($this->finder as $file) {
            $filePath = $file->getRealPath();
            if ($filePath) {
                echo "New receipt detected: $filePath\n";
                try {
                    $text = $this->ocr->processReceipt($filePath);
                    $parsed = $this->parser->parse($text);
                    echo "Parsed receipt: " . print_r($parsed, true) . "\n";
                } catch (\Exception $e) {
                    echo "Failed to process new receipt: " . $e->getMessage() . "\n";
                }
            }
        }

        echo "Watching for new receipts in {$this->receiptsDir}\n";
    }
}
