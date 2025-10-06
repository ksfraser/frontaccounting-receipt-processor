<?php

namespace Tests\Parsing;

use App\Parsing\ReceiptParser;
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
        $ocrOutput = "Supplier: ABC Corp\nDate: 2025-10-05\nItems:\n- Item 1: $10.00\n- Item 2: $20.00";
        $result = $this->parser->parse($ocrOutput);

        $this->assertEquals('ABC Corp', $result['supplier']['name']);
        $this->assertEquals('2025-10-05', $result['date']);
        $this->assertCount(2, $result['items']);
        $this->assertEquals(30.0, $result['totalAmount']);
    }

    public function testParseEmptyReceipt(): void
    {
        $ocrOutput = "";
        $result = $this->parser->parse($ocrOutput);

        $this->assertEquals('', $result['supplier']['name']);
        $this->assertEquals('', $result['date']);
        $this->assertCount(0, $result['items']);
        $this->assertEquals(0.0, $result['totalAmount']);
    }

    public function testParseInvalidReceipt(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid receipt format');

        $ocrOutput = "Invalid data";
        $this->parser->parse($ocrOutput);
    }
}
