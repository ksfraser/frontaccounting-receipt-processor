<?php

namespace Tests\Suppliers;

use App\Models\Supplier;
use App\Suppliers\SupplierService;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class SupplierServiceTest extends TestCase
{
    public function testAddSupplier(): void
    {
        $supplier = new Supplier('1', 'Supplier A');
        $service = new SupplierService();

        $service->addSupplier($supplier);

        $this->assertSame($supplier, $service->getSupplier('1'));
    }

    public function testAddSupplierThrowsExceptionIfExists(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Supplier already exists');

        $supplier = new Supplier('1', 'Supplier A');
        $service = new SupplierService();
        $service->addSupplier($supplier);
        $service->addSupplier($supplier);
    }

    public function testUpdateSupplier(): void
    {
        $supplier = new Supplier('1', 'Supplier A');
        $service = new SupplierService();
        $service->addSupplier($supplier);

        $updatedSupplier = new Supplier('1', 'Updated Supplier A');
        $service->updateSupplier($updatedSupplier);

        $this->assertSame($updatedSupplier, $service->getSupplier('1'));
    }

    public function testUpdateSupplierThrowsExceptionIfNotExists(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Supplier does not exist');

        $supplier = new Supplier('1', 'Supplier A');
        $service = new SupplierService();
        $service->updateSupplier($supplier);
    }

    public function testGetSupplier(): void
    {
        $supplier = new Supplier('1', 'Supplier A');
        $service = new SupplierService();
        $service->addSupplier($supplier);

        $this->assertSame($supplier, $service->getSupplier('1'));
    }

    public function testGetSupplierReturnsNullIfNotExists(): void
    {
        $service = new SupplierService();
        $this->assertNull($service->getSupplier('1'));
    }

    public function testGetAllSuppliers(): void
    {
        $supplier1 = new Supplier('1', 'Supplier A');
        $supplier2 = new Supplier('2', 'Supplier B');

        $service = new SupplierService();
        $service->addSupplier($supplier1);
        $service->addSupplier($supplier2);

        $this->assertEquals([$supplier1, $supplier2], $service->getAllSuppliers());
    }

    public function testRemoveSupplier(): void
    {
        $supplier = new Supplier('1', 'Supplier A');
        $service = new SupplierService();
        $service->addSupplier($supplier);
        $service->removeSupplier('1');

        $this->assertNull($service->getSupplier('1'));
    }

    public function testRemoveSupplierThrowsExceptionIfNotExists(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Supplier does not exist');

        $service = new SupplierService();
        $service->removeSupplier('1');
    }
}
