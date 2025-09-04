export class ItemService {
    private items: Map<string, { name: string; price: number; usage: number }> = new Map();

    createItem(id: string, name: string, price: number): void {
        if (this.items.has(id)) {
            throw new Error('Item already exists');
        }
        this.items.set(id, { name, price, usage: 0 });
    }

    updateItem(id: string, name?: string, price?: number): void {
        const item = this.items.get(id);
        if (!item) {
            throw new Error('Item not found');
        }
        if (name) {
            item.name = name;
        }
        if (price !== undefined) {
            item.price = price;
        }
    }

    getItem(id: string): { name: string; price: number; usage: number } | undefined {
        return this.items.get(id);
    }

    trackUsage(id: string, quantity: number): void {
        const item = this.items.get(id);
        if (!item) {
            throw new Error('Item not found');
        }
        item.usage += quantity;
    }

    getUsage(id: string): number | undefined {
        const item = this.items.get(id);
        return item ? item.usage : undefined;
    }

    getAllItems(): Array<{ id: string; name: string; price: number; usage: number }> {
        return Array.from(this.items.entries()).map(([id, item]) => ({
            id,
            ...item,
        }));
    }
}