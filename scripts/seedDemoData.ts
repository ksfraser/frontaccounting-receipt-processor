import { Repository } from '../src/storage/repository';
import { Supplier } from '../src/storage/models/Supplier';
import { Item } from '../src/storage/models/Item';
import { PricePoint } from '../src/storage/models/PricePoint';
import { Invoice } from '../src/storage/models/Invoice';

async function seedDemoData() {
    const repository = new Repository();

    // Create demo suppliers
    const supplier1 = new Supplier('Supplier A', '123 Main St', 'supplierA@example.com');
    const supplier2 = new Supplier('Supplier B', '456 Elm St', 'supplierB@example.com');
    await repository.saveSupplier(supplier1);
    await repository.saveSupplier(supplier2);

    // Create demo items
    const item1 = new Item('Item A', 'Description for Item A', supplier1.id);
    const item2 = new Item('Item B', 'Description for Item B', supplier2.id);
    await repository.saveItem(item1);
    await repository.saveItem(item2);

    // Create demo price points
    const pricePoint1 = new PricePoint(item1.id, 10.00, new Date());
    const pricePoint2 = new PricePoint(item2.id, 15.00, new Date());
    await repository.savePricePoint(pricePoint1);
    await repository.savePricePoint(pricePoint2);

    // Create demo invoices
    const invoice1 = new Invoice(supplier1.id, [item1.id], new Date(), 10.00);
    const invoice2 = new Invoice(supplier2.id, [item2.id], new Date(), 15.00);
    await repository.saveInvoice(invoice1);
    await repository.saveInvoice(invoice2);

    console.log('Demo data seeded successfully.');
}

seedDemoData().catch(error => {
    console.error('Error seeding demo data:', error);
});