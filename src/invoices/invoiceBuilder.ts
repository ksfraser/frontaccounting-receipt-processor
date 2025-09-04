export class InvoiceBuilder {
    private items: any[];
    private supplierId: string;
    private totalAmount: number;

    constructor(supplierId: string) {
        this.supplierId = supplierId;
        this.items = [];
        this.totalAmount = 0;
    }

    public addItem(item: any, quantity: number, price: number): void {
        this.items.push({ item, quantity, price });
        this.totalAmount += quantity * price;
    }

    public buildInvoice(): any {
        return {
            supplierId: this.supplierId,
            items: this.items,
            totalAmount: this.totalAmount,
            date: new Date(),
        };
    }

    public clearInvoice(): void {
        this.items = [];
        this.totalAmount = 0;
    }
}