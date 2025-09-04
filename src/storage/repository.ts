export class Repository {
    private items: Item[] = [];
    private suppliers: Supplier[] = [];
    private invoices: Invoice[] = [];
    private pricePoints: PricePoint[] = [];

    public addItem(item: Item): void {
        this.items.push(item);
    }

    public getItems(): Item[] {
        return this.items;
    }

    public addSupplier(supplier: Supplier): void {
        this.suppliers.push(supplier);
    }

    public getSuppliers(): Supplier[] {
        return this.suppliers;
    }

    public addInvoice(invoice: Invoice): void {
        this.invoices.push(invoice);
    }

    public getInvoices(): Invoice[] {
        return this.invoices;
    }

    public addPricePoint(pricePoint: PricePoint): void {
        this.pricePoints.push(pricePoint);
    }

    public getPricePoints(): PricePoint[] {
        return this.pricePoints;
    }

    public findItemById(id: string): Item | undefined {
        return this.items.find(item => item.id === id);
    }

    public findSupplierById(id: string): Supplier | undefined {
        return this.suppliers.find(supplier => supplier.id === id);
    }

    public findInvoiceById(id: string): Invoice | undefined {
        return this.invoices.find(invoice => invoice.id === id);
    }

    public findPricePointByItemId(itemId: string): PricePoint[] {
        return this.pricePoints.filter(pricePoint => pricePoint.itemId === itemId);
    }
}