<?php

namespace App\Normalization;

class Currency
{
    public static function normalizeCurrency(string $value): float
    {
        $cleanedValue = preg_replace('/[^0-9.\-]+/', '', $value);
        $parsedValue = floatval($cleanedValue);
        return is_nan($parsedValue) ? 0 : $parsedValue;
    }

    public static function formatCurrency(float $value, string $currencySymbol = '$'): string
    {
        return $currencySymbol . number_format($value, 2, '.', '');
    }
}
