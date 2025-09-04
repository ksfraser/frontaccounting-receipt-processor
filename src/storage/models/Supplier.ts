export class Supplier {
    id: number;
    name: string;
    contactInfo: string;
    address: string;
    createdAt: Date;
    updatedAt: Date;

    constructor(id: number, name: string, contactInfo: string, address: string) {
        this.id = id;
        this.name = name;
        this.contactInfo = contactInfo;
        this.address = address;
        this.createdAt = new Date();
        this.updatedAt = new Date();
    }

    updateContactInfo(newContactInfo: string) {
        this.contactInfo = newContactInfo;
        this.updatedAt = new Date();
    }

    updateAddress(newAddress: string) {
        this.address = newAddress;
        this.updatedAt = new Date();
    }
}