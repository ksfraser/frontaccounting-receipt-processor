<?php

namespace App\Parsing;

class ParsedItem
{
    public string $description;
    public float $unitPrice;
    public int $quantity;

    public function __construct(string $description, float $unitPrice, int $quantity = 1)
    {
        $this->description = $description;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
    }
}
