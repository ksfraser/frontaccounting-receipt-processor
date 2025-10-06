import axios from 'axios';
import fs from 'fs';
import FormData from 'form-data';

class FaClient {
    private baseUrl: string;
    private apiKey: string;

    constructor(baseUrl: string, apiKey: string) {
        this.baseUrl = baseUrl;
        this.apiKey = apiKey;
    }

    public async request(method: string, endpoint: string, data?: any) {
        const url = `${this.baseUrl}/${endpoint}`;
        const headers = {
            'Authorization': `Bearer ${this.apiKey}`,
            'Content-Type': 'application/json',
        };

        const response = await axios({
            method,
            url,
            headers,
            data,
        });

        return response.data;
    }

    public async createInvoice(invoiceData: any) {
        return this.request('POST', 'invoices', invoiceData);
    }

    public async getSuppliers() {
        return this.request('GET', 'suppliers');
    }

    public async createSupplier(supplierData: any) {
        return this.request('POST', 'suppliers', supplierData);
    }

    public async createItem(itemData: any) {
        return this.request('POST', 'items', itemData);
    }

    public async getItemPrices(itemId: string) {
        return this.request('GET', `items/${itemId}/prices`);
    }

    // Attach a file to an invoice (if FA API supports file uploads)
    public async attachFileToInvoice(invoiceId: string | number, filePath: string) {
        const url = `${this.baseUrl}/invoices/${invoiceId}/attachments`;
        const headers = {
            'Authorization': `Bearer ${this.apiKey}`
        };
        const formData = new FormData();
        formData.append('file', fs.createReadStream(filePath));
        const response = await axios.post(url, formData, { headers });
        return response.data;
    }
}

export default FaClient;