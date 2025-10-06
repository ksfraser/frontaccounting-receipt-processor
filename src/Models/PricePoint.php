<?php

namespace App\Models;

class PricePoint
{
    private string $id;
    private string $itemId;
    private float $price;

    public function __construct(string $id, string $itemId, float $price)
    {
        $this->id = $id;
        $this->itemId = $itemId;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
