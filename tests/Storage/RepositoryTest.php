<?php

namespace Tests\Storage;

use PHPUnit\Framework\TestCase;
use App\Storage\Repository;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Invoice;
use App\Models\PricePoint;

class RepositoryTest extends TestCase
{
    private Repository $repository;

    protected function setUp(): void
    {
        $this->repository = new Repository();
    }

    public function testAddAndGetItems(): void
    {
        $item = new Item("1", "Test Item");
        $this->repository->addItem($item);

        $items = $this->repository->getItems();
        $this->assertCount(1, $items);
        $this->assertSame($item, $items[0]);
    }

    public function testFindItemById(): void
    {
        $item = new Item("1", "Test Item");
        $this->repository->addItem($item);

        $foundItem = $this->repository->findItemById("1");
        $this->assertSame($item, $foundItem);

        $notFoundItem = $this->repository->findItemById("2");
        $this->assertNull($notFoundItem);
    }

    public function testAddAndGetSuppliers(): void
    {
        $supplier = new Supplier("1", "Test Supplier");
        $this->repository->addSupplier($supplier);

        $suppliers = $this->repository->getSuppliers();
        $this->assertCount(1, $suppliers);
        $this->assertSame($supplier, $suppliers[0]);
    }

    public function testFindSupplierById(): void
    {
        $supplier = new Supplier("1", "Test Supplier");
        $this->repository->addSupplier($supplier);

        $foundSupplier = $this->repository->findSupplierById("1");
        $this->assertSame($supplier, $foundSupplier);

        $notFoundSupplier = $this->repository->findSupplierById("2");
        $this->assertNull($notFoundSupplier);
    }

    public function testAddAndGetInvoices(): void
    {
        $invoice = new Invoice("1", "Test Invoice");
        $this->repository->addInvoice($invoice);

        $invoices = $this->repository->getInvoices();
        $this->assertCount(1, $invoices);
        $this->assertSame($invoice, $invoices[0]);
    }

    public function testFindInvoiceById(): void
    {
        $invoice = new Invoice("1", "Test Invoice");
        $this->repository->addInvoice($invoice);

        $foundInvoice = $this->repository->findInvoiceById("1");
        $this->assertSame($invoice, $foundInvoice);

        $notFoundInvoice = $this->repository->findInvoiceById("2");
        $this->assertNull($notFoundInvoice);
    }

    public function testAddAndGetPricePoints(): void
    {
        $pricePoint = new PricePoint("1", "1", 100.0);
        $this->repository->addPricePoint($pricePoint);

        $pricePoints = $this->repository->getPricePoints();
        $this->assertCount(1, $pricePoints);
        $this->assertSame($pricePoint, $pricePoints[0]);
    }

    public function testFindPricePointByItemId(): void
    {
        $pricePoint = new PricePoint("1", "1", 100.0);
        $this->repository->addPricePoint($pricePoint);

        $foundPricePoints = $this->repository->findPricePointByItemId("1");
        $this->assertCount(1, $foundPricePoints);
        $this->assertSame($pricePoint, $foundPricePoints[0]);

        $notFoundPricePoints = $this->repository->findPricePointByItemId("2");
        $this->assertCount(0, $notFoundPricePoints);
    }
}
