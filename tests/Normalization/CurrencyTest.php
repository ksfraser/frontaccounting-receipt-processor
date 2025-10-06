<?php

use PHPUnit\Framework\TestCase;
use App\Normalization\Currency;

class CurrencyTest extends TestCase
{
    public function testNormalizeCurrency(): void
    {
        $this->assertEquals(1234.56, Currency::normalizeCurrency('$1,234.56'));
        $this->assertEquals(-1234.56, Currency::normalizeCurrency('-$1,234.56'));
        $this->assertEquals(0, Currency::normalizeCurrency('invalid'));
    }

    public function testFormatCurrency(): void
    {
        $this->assertEquals('$1234.56', Currency::formatCurrency(1234.56));
        $this->assertEquals('€1234.56', Currency::formatCurrency(1234.56, '€'));
        $this->assertEquals('$0.00', Currency::formatCurrency(0));
    }
}
