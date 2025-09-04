export class UsageTracker {
    private usageData: Map<string, { count: number; lastUsed: Date }>;

    constructor() {
        this.usageData = new Map();
    }

    public trackUsage(itemId: string): void {
        const currentDate = new Date();
        if (this.usageData.has(itemId)) {
            const itemUsage = this.usageData.get(itemId)!;
            itemUsage.count += 1;
            itemUsage.lastUsed = currentDate;
        } else {
            this.usageData.set(itemId, { count: 1, lastUsed: currentDate });
        }
    }

    public getUsage(itemId: string): { count: number; lastUsed: Date } | undefined {
        return this.usageData.get(itemId);
    }

    public getAllUsage(): Map<string, { count: number; lastUsed: Date }> {
        return this.usageData;
    }

    public clearUsage(itemId: string): void {
        this.usageData.delete(itemId);
    }

    // Snapshot for budgeting: interpret count as quantity
    public getUsageData(): Array<{ itemId: string; quantity: number }> {
        return Array.from(this.usageData.entries()).map(([itemId, data]) => ({ itemId, quantity: data.count }));
    }
}