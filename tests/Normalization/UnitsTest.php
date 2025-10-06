<?php

use PHPUnit\Framework\TestCase;
use App\Normalization\Units;

class UnitsTest extends TestCase
{
    public function testNormalizeUnit(): void
    {
        $this->assertEquals('kilogram', Units::normalizeUnit('kg'));
        $this->assertEquals('gram', Units::normalizeUnit('g'));
        $this->assertEquals('liter', Units::normalizeUnit('l'));
        $this->assertEquals('unknown', Units::normalizeUnit('unknown'));
    }

    public function testConvertToBaseUnit(): void
    {
        $this->assertEquals(1000, Units::convertToBaseUnit(1, 'kg'));
        $this->assertEquals(1, Units::convertToBaseUnit(1, 'g'));
        $this->assertEquals(1000, Units::convertToBaseUnit(1, 'l'));
        $this->assertEquals(0.01, Units::convertToBaseUnit(1, 'cm'));
        $this->assertEquals(1, Units::convertToBaseUnit(1, 'unknown'));
    }
}
