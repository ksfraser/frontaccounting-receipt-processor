<?php

namespace App\Normalization;

class Units
{
    private static array $normalizedUnits = [
        'kg' => 'kilogram',
        'g' => 'gram',
        'l' => 'liter',
        'ml' => 'milliliter',
        'm' => 'meter',
        'cm' => 'centimeter',
        'mm' => 'millimeter',
        'pcs' => 'pieces',
        'box' => 'boxes',
        'bottle' => 'bottles',
    ];

    private static array $conversionFactors = [
        'kg' => 1000,
        'g' => 1,
        'l' => 1000,
        'ml' => 1,
        'm' => 1,
        'cm' => 0.01,
        'mm' => 0.001,
        'pcs' => 1,
        'box' => 1, // Assuming 1 box is 1 unit for simplicity
        'bottle' => 1, // Assuming 1 bottle is 1 unit for simplicity
    ];

    public static function normalizeUnit(string $unit): string
    {
        $unitLower = strtolower($unit);
        return self::$normalizedUnits[$unitLower] ?? $unit;
    }

    public static function convertToBaseUnit(float $value, string $unit): float
    {
        $unitLower = strtolower($unit);
        return $value * (self::$conversionFactors[$unitLower] ?? 1);
    }
}
