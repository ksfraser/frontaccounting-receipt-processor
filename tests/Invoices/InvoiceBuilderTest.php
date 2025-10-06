<?php

namespace Tests\Invoices;

use App\Invoices\InvoiceBuilder;
use PHPUnit\Framework\TestCase;

class InvoiceBuilderTest extends TestCase
{
    private InvoiceBuilder $invoiceBuilder;

    protected function setUp(): void
    {
        $this->invoiceBuilder = new InvoiceBuilder('supplier123');
    }

    public function testAddItem(): void
    {
        $this->invoiceBuilder->addItem(['id' => 'item1'], 2, 10.0);
        $invoice = $this->invoiceBuilder->buildInvoice();

        $this->assertCount(1, $invoice['items']);
        $this->assertEquals(20.0, $invoice['totalAmount']);
    }

    public function testBuildInvoice(): void
    {
        $this->invoiceBuilder->addItem(['id' => 'item1'], 2, 10.0);
        $this->invoiceBuilder->addItem(['id' => 'item2'], 1, 15.0);
        $invoice = $this->invoiceBuilder->buildInvoice();

        $this->assertEquals('supplier123', $invoice['supplierId']);
        $this->assertCount(2, $invoice['items']);
        $this->assertEquals(35.0, $invoice['totalAmount']);
        $this->assertInstanceOf(\DateTime::class, $invoice['date']);
    }

    public function testClearInvoice(): void
    {
        $this->invoiceBuilder->addItem(['id' => 'item1'], 2, 10.0);
        $this->invoiceBuilder->clearInvoice();
        $invoice = $this->invoiceBuilder->buildInvoice();

        $this->assertCount(0, $invoice['items']);
        $this->assertEquals(0.0, $invoice['totalAmount']);
    }
}
