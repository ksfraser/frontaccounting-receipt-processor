export class Invoice {
    id: string;
    supplierId: string;
    items: Array<{ itemId: string; quantity: number; price: number }>;
    totalAmount: number;
    date: Date;

    constructor(id: string, supplierId: string, items: Array<{ itemId: string; quantity: number; price: number }>, totalAmount: number, date: Date) {
        this.id = id;
        this.supplierId = supplierId;
        this.items = items;
        this.totalAmount = totalAmount;
        this.date = date;
    }

    calculateTotal(): number {
        return this.items.reduce((total, item) => total + (item.quantity * item.price), 0);
    }

    toJSON(): object {
        return {
            id: this.id,
            supplierId: this.supplierId,
            items: this.items,
            totalAmount: this.calculateTotal(),
            date: this.date.toISOString(),
        };
    }
}