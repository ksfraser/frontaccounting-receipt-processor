<?php

namespace App\Parsing\Mappers;

class Supplier
{
    private string $id;
    private string $name;
    private string $contactInfo;
    private string $address;

    public function __construct(string $id, string $name, string $contactInfo, string $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->contactInfo = $contactInfo;
        $this->address = $address;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContactInfo(): string
    {
        return $this->contactInfo;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}

class SupplierMapper
{
    public static function mapSupplierData(array $parsedData): Supplier
    {
        return new Supplier(
            $parsedData['supplierId'],
            $parsedData['supplierName'],
            $parsedData['supplierContact'],
            $parsedData['supplierAddress']
        );
    }
}
