export class SupplierService {
    private suppliers: Map<string, Supplier>;

    constructor() {
        this.suppliers = new Map();
    }

    addSupplier(supplier: Supplier): void {
        if (this.suppliers.has(supplier.id)) {
            throw new Error('Supplier already exists');
        }
        this.suppliers.set(supplier.id, supplier);
    }

    updateSupplier(supplier: Supplier): void {
        if (!this.suppliers.has(supplier.id)) {
            throw new Error('Supplier does not exist');
        }
        this.suppliers.set(supplier.id, supplier);
    }

    getSupplier(id: string): Supplier | undefined {
        return this.suppliers.get(id);
    }

    getAllSuppliers(): Supplier[] {
        return Array.from(this.suppliers.values());
    }

    removeSupplier(id: string): void {
        if (!this.suppliers.has(id)) {
            throw new Error('Supplier does not exist');
        }
        this.suppliers.delete(id);
    }
}