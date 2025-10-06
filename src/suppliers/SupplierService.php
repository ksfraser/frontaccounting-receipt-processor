<?php

namespace App\Suppliers;

use App\Utils\Errors\AppError;

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
            throw new AppError('Supplier already exists');
        }
        $this->suppliers[$supplier->getId()] = $supplier;
    }

    public function updateSupplier(Supplier $supplier): void
    {
        if (!array_key_exists($supplier->getId(), $this->suppliers)) {
            throw new AppError('Supplier does not exist');
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
            throw new AppError('Supplier does not exist');
        }
        unset($this->suppliers[$id]);
    }
}

/**
 * Class Supplier
 *
 * Represents a supplier entity.
 */
class Supplier
{
    private string $id;
    private string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
