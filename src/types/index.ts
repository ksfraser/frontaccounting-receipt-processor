export type Receipt = {
    id: string;
    supplierId: string;
    date: Date;
    totalAmount: number;
    currency: string;
    items: ReceiptItem[];
};

export type ReceiptItem = {
    description: string;
    quantity: number;
    unitPrice: number;
    totalPrice: number;
};

export type Supplier = {
    id: string;
    name: string;
    contactInfo: string;
};

export type Item = {
    id: string;
    name: string;
    price: number;
    unit: string;
};

export type Invoice = {
    id: string;
    supplierId: string;
    items: InvoiceItem[];
    totalAmount: number;
    dateIssued: Date;
};

export type InvoiceItem = {
    itemId: string;
    quantity: number;
    unitPrice: number;
    totalPrice: number;
};

export type PricePoint = {
    itemId: string;
    price: number;
    date: Date;
};

export type BudgetEntry = {
    id: string;
    amount: number;
    date: Date;
    category: string;
};