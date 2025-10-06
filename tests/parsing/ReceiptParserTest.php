<?php

namespace Tests\Parsing;

use App\Parsing\ReceiptParser;
use App\Parsing\ParsedReceipt;
use App\Parsing\ParsedItem;
use PHPUnit\Framework\TestCase;

class ReceiptParserTest extends TestCase
{
    private ReceiptParser $parser;

    protected function setUp(): void
    {
        $this->parser = new ReceiptParser();
    }

    public function testParseValidReceipt(): void
    {
        $ocrOutput = "Supplier: ABC Corp\nDate: 2025-10-05\nItems:\n- Item A: $10.00\n- Item B: $20.00";

        $parsedReceipt = $this->parser->parse($ocrOutput);

        $this->assertInstanceOf(ParsedReceipt::class, $parsedReceipt);
        $this->assertEquals('2025-10-05', $parsedReceipt->date);
        $this->assertCount(2, $parsedReceipt->items);
        $this->assertEquals(30.0, $parsedReceipt->totalAmount);

        $itemA = $parsedReceipt->items[0];
        $this->assertInstanceOf(ParsedItem::class, $itemA);
        $this->assertEquals('Item A', $itemA->description);
        $this->assertEquals(10.0, $itemA->unitPrice);

        $itemB = $parsedReceipt->items[1];
        $this->assertEquals('Item B', $itemB->description);
        $this->assertEquals(20.0, $itemB->unitPrice);
    }

    public function testParseEmptyReceipt(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('OCR output is empty');

        $this->parser->parse("");
    }

    public function testParseInvalidFormat(): void
    {
        $ocrOutput = "Invalid receipt format";

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid receipt format');

        $this->parser->parse($ocrOutput);
    }
}
