<?php

namespace App\Invoices;

class InvoiceBuilder
{
    private array $items;
    private string $supplierId;
    private float $totalAmount;

    public function __construct(string $supplierId)
    {
        $this->supplierId = $supplierId;
        $this->items = [];
        $this->totalAmount = 0;
    }

    public function addItem(array $item, int $quantity, float $price): void
    {
        $this->items[] = [
            'item' => $item,
            'quantity' => $quantity,
            'price' => $price
        ];
        $this->totalAmount += $quantity * $price;
    }

    public function buildInvoice(): array
    {
        return [
            'supplierId' => $this->supplierId,
            'items' => $this->items,
            'totalAmount' => $this->totalAmount,
            'date' => new \DateTime(),
        ];
    }

    public function clearInvoice(): void
    {
        $this->items = [];
        $this->totalAmount = 0;
    }
}
