export class PriceTracker {
    private priceHistory: Map<string, number[]>;

    constructor() {
        this.priceHistory = new Map();
    }

    public addPrice(itemId: string, price: number): void {
        if (!this.priceHistory.has(itemId)) {
            this.priceHistory.set(itemId, []);
        }
        this.priceHistory.get(itemId)?.push(price);
    }

    public getPriceHistory(itemId: string): number[] | undefined {
        return this.priceHistory.get(itemId);
    }

    public getCurrentPrice(itemId: string): number | undefined {
        const prices = this.priceHistory.get(itemId);
        return prices ? prices[prices.length - 1] : undefined;
    }

    public getAveragePrice(itemId: string): number | undefined {
        const prices = this.priceHistory.get(itemId);
        if (!prices || prices.length === 0) return undefined;
        const total = prices.reduce((acc, price) => acc + price, 0);
        return total / prices.length;
    }

    public getPriceProjection(itemId: string, futurePeriods: number): number | undefined {
        const currentPrice = this.getCurrentPrice(itemId);
        const averagePrice = this.getAveragePrice(itemId);
        if (currentPrice === undefined || averagePrice === undefined) return undefined;

        const projectedPrice = currentPrice + (currentPrice - averagePrice) * futurePeriods;
        return projectedPrice;
    }

    public getPriceData(): Array<{ itemId: string; price: number }> {
        const result: Array<{ itemId: string; price: number }> = [];
        for (const [itemId, prices] of this.priceHistory.entries()) {
            if (prices.length) {
                result.push({ itemId, price: prices[prices.length - 1] });
            }
        }
        return result;
    }
}