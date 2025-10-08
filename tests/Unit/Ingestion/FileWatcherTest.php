<?php

namespace Tests\Unit\Ingestion;

use App\Ingestion\FileWatcher;
use App\OCR\OcrProviderInterface;
use PHPUnit\Framework\TestCase;

class FileWatcherTest extends TestCase
{
    private FileWatcher $fileWatcher;
    private string $receiptsDir;

    protected function setUp(): void
    {
        $ocrProviderMock = $this->createMock(OcrProviderInterface::class);
        $this->fileWatcher = new FileWatcher($ocrProviderMock);
        $this->receiptsDir = __DIR__ . '/../../receipts';
    }

    protected function tearDown(): void
    {
        if (is_dir($this->receiptsDir)) {
            rmdir($this->receiptsDir);
        }
    }

    public function testStartCreatesReceiptsDirectory(): void
    {
        // Ensure the directory does not exist before the test
        if (is_dir($this->receiptsDir)) {
            rmdir($this->receiptsDir);
        }

        $this->fileWatcher->start();

        $this->assertTrue(is_dir($this->receiptsDir), 'Receipts directory should be created.');
    }
}
