<?php

namespace App\Parsing\Mappers;

class Item
{
    private string $id;
    private string $name;
    private int $quantity;
    private float $price;

    public function __construct(string $id, string $name, int $quantity, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}

class ItemMapper
{
    public static function mapItemData(array $parsedData): Item
    {
        return new Item(
            $parsedData['itemId'],
            $parsedData['itemName'],
            $parsedData['itemQuantity'],
            $parsedData['itemPrice']
        );
    }
}
