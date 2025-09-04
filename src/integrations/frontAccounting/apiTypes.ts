export interface ApiResponse<T> {
    success: boolean;
    data?: T;
    error?: string;
}

export interface Supplier {
    id: number;
    name: string;
    contactInfo: string;
}

export interface Item {
    id: number;
    name: string;
    price: number;
    unit: string;
}

export interface Invoice {
    id: number;
    supplierId: number;
    items: InvoiceItem[];
    totalAmount: number;
    date: string;
}

export interface InvoiceItem {
    itemId: number;
    quantity: number;
    price: number;
}

export interface PricePoint {
    itemId: number;
    price: number;
    date: string;
}