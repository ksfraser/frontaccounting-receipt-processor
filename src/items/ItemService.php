<?php

namespace App\Items;

use App\Utils\Errors\AppError;

class ItemService
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function createItem(string $id, string $name, float $price): void
    {
        if (isset($this->items[$id])) {
            throw new AppError('Item already exists');
        }
        $this->items[$id] = ['name' => $name, 'price' => $price, 'usage' => 0];
    }

    public function updateItem(string $id, ?string $name = null, ?float $price = null): void
    {
        if (!isset($this->items[$id])) {
            throw new AppError('Item not found');
        }
        if ($name !== null) {
            $this->items[$id]['name'] = $name;
        }
        if ($price !== null) {
            $this->items[$id]['price'] = $price;
        }
    }

    public function getItem(string $id): ?array
    {
        return $this->items[$id] ?? null;
    }

    public function trackUsage(string $id, int $quantity): void
    {
        if (!isset($this->items[$id])) {
            throw new AppError('Item not found');
        }
        $this->items[$id]['usage'] += $quantity;
    }

    public function getUsage(string $id): ?int
    {
        return $this->items[$id]['usage'] ?? null;
    }

    public function getAllItems(): array
    {
        $result = [];
        foreach ($this->items as $id => $item) {
            $result[] = array_merge(['id' => $id], $item);
        }
        return $result;
    }
}
