<?php

namespace Tests\Unit\Ingestion;

use App\Ingestion\FileWatcher;
use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use App\Parsing\ParsedReceipt;
use App\OCR\OcrProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class FileWatcherTest extends TestCase
{
    private FileWatcher $fileWatcher;

    protected function setUp(): void
    {
        $ocrProviderMock = $this->createMock(OcrProviderInterface::class);
        $this->fileWatcher = new FileWatcher($ocrProviderMock);
    }

    public function testStartCreatesReceiptsDirectory(): void
    {
        $receiptsDir = __DIR__ . '/../../receipts';

        // Ensure the directory does not exist before the test
        if (is_dir($receiptsDir)) {
            rmdir($receiptsDir);
        }

        $this->fileWatcher->start();

        $this->assertTrue(is_dir($receiptsDir), 'Receipts directory should be created.');

        // Cleanup
        rmdir($receiptsDir);
    }

    public function testProcessFileLogsParsedReceipt(): void
    {
        $ocrProviderMock = $this->createMock(OcrProviderInterface::class);
        $parserMock = $this->createMock(ReceiptParser::class);

        $ocrProviderMock->method('recognize')->willReturn('Mocked OCR Text');

        $parsedReceiptMock = $this->createMock(ParsedReceipt::class);
        $parserMock->method('parse')->willReturn($parsedReceiptMock);

        $fileWatcher = new FileWatcher($ocrProviderMock);

        // Replace the real parser with a mock
        $reflection = new \ReflectionClass($fileWatcher);
        $parserProperty = $reflection->getProperty('parser');
        $parserProperty->setAccessible(true);
        $parserProperty->setValue($fileWatcher, $parserMock);

        // Capture output
        ob_start();
        $fileWatcher->start();
        $output = ob_get_clean();

        $this->assertStringContainsString('Parsed receipt', $output);
    }
}
