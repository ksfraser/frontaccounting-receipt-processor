import { FaClient } from '../integrations/frontAccounting/faClient';
import { InvoiceBuilder } from '../invoices/invoiceBuilder';
import { Repository } from '../storage/repository';
import { SupplierService } from '../suppliers/supplierService';
import { ItemService } from '../items/itemService';

async function syncFrontAccounting() {
    const faClient = new FaClient();
    const repository = new Repository();
    const supplierService = new SupplierService(repository);
    const itemService = new ItemService(repository);
    const invoiceBuilder = new InvoiceBuilder();

    try {
        // Fetch suppliers from Front Accounting
        const suppliers = await faClient.getSuppliers();
        await supplierService.syncSuppliers(suppliers);

        // Fetch items from Front Accounting
        const items = await faClient.getItems();
        await itemService.syncItems(items);

        // Fetch invoices from Front Accounting
        const invoices = await faClient.getInvoices();
        for (const invoiceData of invoices) {
            const invoice = invoiceBuilder.buildInvoice(invoiceData);
            await repository.saveInvoice(invoice);
        }

        console.log('Synchronization with Front Accounting completed successfully.');
    } catch (error) {
        console.error('Error during synchronization:', error);
    }
}

syncFrontAccounting();