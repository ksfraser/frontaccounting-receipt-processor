export interface Supplier {
    id: string;
    name: string;
    contactInfo: string;
    address: string;
}

export function mapSupplierData(parsedData: any): Supplier {
    return {
        id: parsedData.supplierId,
        name: parsedData.supplierName,
        contactInfo: parsedData.supplierContact,
        address: parsedData.supplierAddress,
    };
}