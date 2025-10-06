<?php

namespace Tests\Suppliers;

use App\Suppliers\Supplier;
use App\Suppliers\SupplierService;
use App\Utils\Errors\AppError;
use PHPUnit\Framework\TestCase;

class SupplierServiceTest extends TestCase
{
    private SupplierService $supplierService;

    protected function setUp(): void
    {
        $this->supplierService = new SupplierService();
    }

    public function testAddSupplier(): void
    {
        $supplier = new Supplier('1', 'Supplier A');
        $this->supplierService->addSupplier($supplier);

        $this->assertSame($supplier, $this->supplierService->getSupplier('1'));
    }

    public function testAddDuplicateSupplier(): void
    {
        $this->expectException(AppError::class);
        $this->expectExceptionMessage('Supplier already exists');

        $supplier = new Supplier('1', 'Supplier A');
        $this->supplierService->addSupplier($supplier);
        $this->supplierService->addSupplier($supplier);
    }

    public function testUpdateSupplier(): void
    {
        $supplier = new Supplier('1', 'Supplier A');
        $this->supplierService->addSupplier($supplier);

        $updatedSupplier = new Supplier('1', 'Updated Supplier A');
        $this->supplierService->updateSupplier($updatedSupplier);

        $this->assertSame($updatedSupplier, $this->supplierService->getSupplier('1'));
    }

    public function testUpdateNonExistentSupplier(): void
    {
        $this->expectException(AppError::class);
        $this->expectExceptionMessage('Supplier does not exist');

        $supplier = new Supplier('1', 'Supplier A');
        $this->supplierService->updateSupplier($supplier);
    }

    public function testRemoveSupplier(): void
    {
        $supplier = new Supplier('1', 'Supplier A');
        $this->supplierService->addSupplier($supplier);
        $this->supplierService->removeSupplier('1');

        $this->assertNull($this->supplierService->getSupplier('1'));
    }

    public function testRemoveNonExistentSupplier(): void
    {
        $this->expectException(AppError::class);
        $this->expectExceptionMessage('Supplier does not exist');

        $this->supplierService->removeSupplier('1');
    }

    public function testGetAllSuppliers(): void
    {
        $supplier1 = new Supplier('1', 'Supplier A');
        $supplier2 = new Supplier('2', 'Supplier B');

        $this->supplierService->addSupplier($supplier1);
        $this->supplierService->addSupplier($supplier2);

        $allSuppliers = $this->supplierService->getAllSuppliers();

        $this->assertCount(2, $allSuppliers);
        $this->assertContains($supplier1, $allSuppliers);
        $this->assertContains($supplier2, $allSuppliers);
    }
}
