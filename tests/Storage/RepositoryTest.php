<?php

namespace Tests\Storage;

use App\Storage\Repository;
use App\Storage\Item;
use App\Storage\Supplier;
use App\Storage\Invoice;
use App\Storage\PricePoint;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    private Repository $repository;

    protected function setUp(): void
    {
        $this->repository = new Repository();
    }

    public function testAddAndGetItems(): void
    {
        $item = new Item('item1');
        $this->repository->addItem($item);

        $items = $this->repository->getItems();
        $this->assertCount(1, $items);
        $this->assertSame($item, $items[0]);
    }

    public function testFindItemById(): void
    {
        $item = new Item('item1');
        $this->repository->addItem($item);

        $foundItem = $this->repository->findItemById('item1');
        $this->assertSame($item, $foundItem);
    }

    public function testAddAndGetSuppliers(): void
    {
        $supplier = new Supplier('supplier1');
        $this->repository->addSupplier($supplier);

        $suppliers = $this->repository->getSuppliers();
        $this->assertCount(1, $suppliers);
        $this->assertSame($supplier, $suppliers[0]);
    }

    public function testFindSupplierById(): void
    {
        $supplier = new Supplier('supplier1');
        $this->repository->addSupplier($supplier);

        $foundSupplier = $this->repository->findSupplierById('supplier1');
        $this->assertSame($supplier, $foundSupplier);
    }

    public function testAddAndGetInvoices(): void
    {
        $invoice = new Invoice('invoice1');
        $this->repository->addInvoice($invoice);

        $invoices = $this->repository->getInvoices();
        $this->assertCount(1, $invoices);
        $this->assertSame($invoice, $invoices[0]);
    }

    public function testFindInvoiceById(): void
    {
        $invoice = new Invoice('invoice1');
        $this->repository->addInvoice($invoice);

        $foundInvoice = $this->repository->findInvoiceById('invoice1');
        $this->assertSame($foundInvoice, $invoice);
    }

    public function testAddAndGetPricePoints(): void
    {
        $pricePoint = new PricePoint('item1');
        $this->repository->addPricePoint($pricePoint);

        $pricePoints = $this->repository->getPricePoints();
        $this->assertCount(1, $pricePoints);
        $this->assertSame($pricePoint, $pricePoints[0]);
    }

    public function testFindPricePointByItemId(): void
    {
        $pricePoint = new PricePoint('item1');
        $this->repository->addPricePoint($pricePoint);

        $foundPricePoints = $this->repository->findPricePointByItemId('item1');
        $this->assertCount(1, $foundPricePoints);
        $this->assertSame($pricePoint, $foundPricePoints[0]);
    }
}
