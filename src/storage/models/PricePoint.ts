export class PricePoint {
    itemId: string;
    price: number;
    date: Date;

    constructor(itemId: string, price: number, date: Date) {
        this.itemId = itemId;
        this.price = price;
        this.date = date;
    }
}