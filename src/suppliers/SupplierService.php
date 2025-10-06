<?php

namespace App\Suppliers;

use App\Models\Supplier;
use InvalidArgumentException;

class SupplierService
{
    private array $suppliers;

    public function __construct()
    {
        $this->suppliers = [];
    }

    public function addSupplier(Supplier $supplier): void
    {
        if (array_key_exists($supplier->getId(), $this->suppliers)) {
            throw new InvalidArgumentException('Supplier already exists');
        }
        $this->suppliers[$supplier->getId()] = $supplier;
    }

    public function updateSupplier(Supplier $supplier): void
    {
        if (!array_key_exists($supplier->getId(), $this->suppliers)) {
            throw new InvalidArgumentException('Supplier does not exist');
        }
        $this->suppliers[$supplier->getId()] = $supplier;
    }

    public function getSupplier(string $id): ?Supplier
    {
        return $this->suppliers[$id] ?? null;
    }

    public function getAllSuppliers(): array
    {
        return array_values($this->suppliers);
    }

    public function removeSupplier(string $id): void
    {
        if (!array_key_exists($id, $this->suppliers)) {
            throw new InvalidArgumentException('Supplier does not exist');
        }
        unset($this->suppliers[$id]);
    }
}
