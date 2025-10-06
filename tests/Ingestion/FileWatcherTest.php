<?php

namespace Tests\Ingestion;

use App\Ingestion\FileWatcher;
use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class FileWatcherTest extends TestCase
{
    private FileWatcher $fileWatcher;
    private OcrService $mockOcrService;
    private ReceiptParser $mockReceiptParser;
    private $vfsRoot;

    protected function setUp(): void
    {
        $this->mockOcrService = $this->createMock(OcrService::class);
        $this->mockReceiptParser = $this->createMock(ReceiptParser::class);

        $this->vfsRoot = vfsStream::setup('receiptsDir');
        $this->fileWatcher = new FileWatcher($this->vfsRoot->url(), $this->mockOcrService, $this->mockReceiptParser);
    }

    public function testStartWithValidFiles(): void
    {
        $fileContent = 'dummy content';
        $parsedData = ['supplier' => 'Test Supplier', 'items' => []];

        $this->mockOcrService->method('processReceipt')->willReturn($fileContent);
        $this->mockReceiptParser->method('parse')->willReturn($parsedData);

        vfsStream::newFile('receipt1.jpg')->at($this->vfsRoot);
        vfsStream::newFile('receipt2.pdf')->at($this->vfsRoot);

        $this->expectOutputRegex('/Watching for new receipts/');
        $this->expectOutputRegex('/New receipt detected/');
        $this->expectOutputRegex('/Parsed receipt/');

        $this->fileWatcher->start();
    }

    public function testStartWithNoDirectory(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Receipts directory does not exist');

        $invalidWatcher = new FileWatcher('/invalid/path', $this->mockOcrService, $this->mockReceiptParser);
        $invalidWatcher->start();
    }
}
