<?php

namespace App\Parsing;

class ParsedReceipt
{
    public string $date;
    public array $supplier;
    public array $items;
    public float $totalAmount;

    public function __construct(string $date, array $supplier, array $items, float $totalAmount)
    {
        $this->date = $date;
        $this->supplier = $supplier;
        $this->items = $items;
        $this->totalAmount = $totalAmount;
    }
}
