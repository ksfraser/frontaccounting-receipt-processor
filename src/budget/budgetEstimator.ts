import { UsageTracker } from '../usage/usageTracker';
import { PriceTracker } from '../pricing/priceTracker';

interface UsageSnapshot { itemId: string; quantity: number; }
interface PriceSnapshot { itemId: string; price: number; }

export class BudgetEstimator {
    constructor(private usageTracker: UsageTracker, private priceTracker: PriceTracker) {}

    public estimateBudget(): number {
        const usageData = this.usageTracker.getUsageData();
        const priceData = this.priceTracker.getPriceData();
        let totalBudget = 0;
        for (const usage of usageData) {
            const pricePoint = priceData.find(p => p.itemId === usage.itemId);
            if (pricePoint) {
                totalBudget += usage.quantity * pricePoint.price;
            }
        }
        return totalBudget;
    }

    public createBudgetEntry(): void {
        const estimatedAmount = this.estimateBudget();
        console.log(`Budget entry: $${estimatedAmount}`);
    }
}