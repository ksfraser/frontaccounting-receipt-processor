export interface ParsedSupplier {
    id: number;
    name: string;
    address: string;
    contactInfo: string;
}

export interface ParsedItem {
    id: number;
    name: string;
    quantity: number;
    price: number;
}

export interface ParsedReceipt {
    supplier: ParsedSupplier;
    date: string;
    items: ParsedItem[];
    totalAmount: number;
}

export class ReceiptParser {
    public parse(ocrOutput: string): ParsedReceipt {
        const normalized = (ocrOutput || '').trim();
        if (!normalized) {
            return {
                supplier: { id: 1, name: '', address: '', contactInfo: '' },
                date: '',
                items: [],
                totalAmount: 0
            };
        }

        const supplierMatch = normalized.match(/Supplier:\s*(.+)/i);
        const dateMatch = normalized.match(/Date:\s*(\d{4}-\d{2}-\d{2})/i);
        const itemsSectionMatch = normalized.match(/Items:([\s\S]*)/i);

        if (!supplierMatch || !dateMatch || !itemsSectionMatch) {
            throw new Error('Invalid receipt format');
        }

        // Dummy address/contact extraction for demo
        const supplier: ParsedSupplier = {
            id: 1,
            name: supplierMatch[1].trim(),
            address: '123 Main St',
            contactInfo: 'info@abc.com',
        };

        const itemsRaw = itemsSectionMatch[1]
            .split(/\n|\r/)
            .map(l => l.trim())
            .filter(l => l.startsWith('-'));

        const items: ParsedItem[] = itemsRaw.map((line, idx) => {
            // Format: - Item 1: $10.00
            const m = line.match(/-\s*(.+?):\s*\$?(\d+\.?\d*)/);
            if (!m) return null; // skip malformed
            return { id: idx + 1, name: m[1].trim(), quantity: 1, price: parseFloat(m[2]) };
        }).filter((i): i is ParsedItem => !!i);

        const totalAmount = items.reduce((sum, item) => sum + item.price * item.quantity, 0);

        return {
            supplier,
            date: dateMatch[1],
            items,
            totalAmount
        };
    }
}