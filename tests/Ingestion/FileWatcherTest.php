<?php

namespace Tests\Ingestion;

use App\Ingestion\FileWatcher;
use App\OCR\OcrProviderInterface;
use App\OCR\OcrService;
use App\Parsing\ReceiptParser;
use App\Parsing\ParsedReceipt;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class FileWatcherTest extends TestCase
{
    private FileWatcher $fileWatcher;
    private OcrProviderInterface $mockOcrProvider;
    private OcrService $mockOcrService;
    private ReceiptParser $mockReceiptParser;
    private $vfsRoot;

    protected function setUp(): void
    {
        $this->mockOcrProvider = $this->createMock(OcrProviderInterface::class);
        $this->mockOcrService = $this->createMock(OcrService::class);
        $this->mockReceiptParser = $this->createMock(ReceiptParser::class);

        $this->vfsRoot = vfsStream::setup('receiptsDir');
        $this->fileWatcher = new FileWatcher($this->mockOcrProvider, $this->vfsRoot->url(), $this->mockReceiptParser, $this->mockOcrService);
    }

    public function testStartWithValidFiles(): void
    {
        $fileContent = 'dummy content';
        $parsedReceipt = new ParsedReceipt('2025-10-05', ['id' => 1, 'name' => 'Test Supplier'], [], 0.0);

        $this->mockOcrService->method('processReceipt')->willReturn($fileContent);
        $this->mockReceiptParser->method('parse')->willReturn($parsedReceipt);

        vfsStream::newFile('receipt1.jpg')->at($this->vfsRoot)->setContent('test content');
        vfsStream::newFile('receipt2.pdf')->at($this->vfsRoot)->setContent('test content');

        $this->expectOutputRegex('/Watching for new receipts/');
        $this->expectOutputRegex('/New receipt detected/');
        $this->expectOutputRegex('/Parsed receipt/');

        $this->fileWatcher->start();
    }

    public function testStartWithNoDirectory(): void
    {
        $this->expectException(\Exception::class);

        $invalidWatcher = new FileWatcher($this->mockOcrProvider, 'Z:\invalid\path\that\does\not\exist', $this->mockReceiptParser, $this->mockOcrService);
        $invalidWatcher->start();
    }
}
