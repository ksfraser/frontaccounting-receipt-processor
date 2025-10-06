<?php

namespace App\Storage;

class Repository
{
    private array $items = [];
    private array $suppliers = [];
    private array $invoices = [];
    private array $pricePoints = [];

    public function addItem(Item $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addSupplier(Supplier $supplier): void
    {
        $this->suppliers[] = $supplier;
    }

    public function getSuppliers(): array
    {
        return $this->suppliers;
    }

    public function addInvoice(Invoice $invoice): void
    {
        $this->invoices[] = $invoice;
    }

    public function getInvoices(): array
    {
        return $this->invoices;
    }

    public function addPricePoint(PricePoint $pricePoint): void
    {
        $this->pricePoints[] = $pricePoint;
    }

    public function getPricePoints(): array
    {
        return $this->pricePoints;
    }

    public function findItemById(string $id): ?Item
    {
        foreach ($this->items as $item) {
            if ($item->getId() === $id) {
                return $item;
            }
        }
        return null;
    }

    public function findSupplierById(string $id): ?Supplier
    {
        foreach ($this->suppliers as $supplier) {
            if ($supplier->getId() === $id) {
                return $supplier;
            }
        }
        return null;
    }

    public function findInvoiceById(string $id): ?Invoice
    {
        foreach ($this->invoices as $invoice) {
            if ($invoice->getId() === $id) {
                return $invoice;
            }
        }
        return null;
    }

    public function findPricePointByItemId(string $itemId): array
    {
        $result = [];
        foreach ($this->pricePoints as $pricePoint) {
            if ($pricePoint->getItemId() === $itemId) {
                $result[] = $pricePoint;
            }
        }
        return $result;
    }
}

// Define the Item, Supplier, Invoice, and PricePoint classes for completeness.
class Item
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}

class Supplier
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}

class Invoice
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}

class PricePoint
{
    private string $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }
}
