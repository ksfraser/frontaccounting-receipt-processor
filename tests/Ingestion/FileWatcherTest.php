<?php

namespace Tests\Ingestion;

use App\Ingestion\FileWatcher;
use App\OCR\OcrProviderInterface;
use App\Parsing\ReceiptParser;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class FileWatcherTest extends TestCase
{
    private FileWatcher $fileWatcher;
    private OcrProviderInterface $mockOcrProvider;
    private ReceiptParser $mockReceiptParser;
    private $vfsRoot;

    protected function setUp(): void
    {
        $this->mockOcrProvider = $this->createMock(OcrProviderInterface::class);
        $this->mockReceiptParser = $this->createMock(ReceiptParser::class);

        $this->vfsRoot = vfsStream::setup('receiptsDir');
        $this->fileWatcher = new FileWatcher($this->mockOcrProvider, $this->vfsRoot->url(), $this->mockReceiptParser);
    }

    public function testStartWithValidFiles(): void
    {
        $fileContent = 'dummy content';
        $parsedData = ['supplier' => 'Test Supplier', 'items' => []];

        $this->mockOcrProvider->method('recognize')->willReturn($fileContent);
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
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Receipts directory does not exist');

        $invalidWatcher = new FileWatcher($this->mockOcrProvider, '/invalid/path', $this->mockReceiptParser);
        $invalidWatcher->start();
    }
}
