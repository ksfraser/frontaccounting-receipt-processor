<?php

use PHPUnit\Framework\TestCase;
use App\Parsing\Mappers\SupplierMapper;
use App\Parsing\Mappers\Supplier;

class SupplierMapperTest extends TestCase
{
    public function testMapSupplierData(): void
    {
        $parsedData = [
            'supplierId' => '123',
            'supplierName' => 'Test Supplier',
            'supplierContact' => 'test@example.com',
            'supplierAddress' => '123 Test Street'
        ];

        $supplier = SupplierMapper::mapSupplierData($parsedData);

        $this->assertInstanceOf(Supplier::class, $supplier);
        $this->assertEquals('123', $supplier->getId());
        $this->assertEquals('Test Supplier', $supplier->getName());
        $this->assertEquals('test@example.com', $supplier->getContactInfo());
        $this->assertEquals('123 Test Street', $supplier->getAddress());
    }
}
