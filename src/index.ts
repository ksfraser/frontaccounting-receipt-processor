import express from 'express';
import { config } from './config';
import { fileWatcher } from './ingestion/fileWatcher';
import { uploadHandler } from './ingestion/uploadHandler';
import logger from './utils/logger';
import { Request, Response } from 'express';

const app = express();
const PORT = config.port || 3000;

// Middleware to parse JSON requests
app.use(express.json());

// Start file watcher for receipts
fileWatcher.start();

// Endpoint for uploading receipts
app.post('/upload', uploadHandler.handleUpload);

// Sync supplier to FA
app.post('/fa/supplier', async (req: Request, res: Response) => {
    const FaClient = (await import('./integrations/frontAccounting/faClient')).default;
    const { config } = await import('./config');
    const faClient = new FaClient(config.faBaseUrl, config.faApiKey);
    try {
        const result = await faClient.createSupplier(req.body);
        res.json({ success: true, result });
    } catch (e: any) {
        res.status(500).json({ success: false, error: e.message });
    }
});

// Sync item to FA
app.post('/fa/item', async (req: Request, res: Response) => {
    const FaClient = (await import('./integrations/frontAccounting/faClient')).default;
    const { config } = await import('./config');
    const faClient = new FaClient(config.faBaseUrl, config.faApiKey);
    try {
        const result = await faClient.createItem(req.body);
        res.json({ success: true, result });
    } catch (e: any) {
        res.status(500).json({ success: false, error: e.message });
    }
});

// Get item prices from FA
app.get('/fa/item/:id/prices', async (req: Request, res: Response) => {
    const FaClient = (await import('./integrations/frontAccounting/faClient')).default;
    const { config } = await import('./config');
    const faClient = new FaClient(config.faBaseUrl, config.faApiKey);
    try {
        const result = await faClient.getItemPrices(req.params.id);
        res.json({ success: true, result });
    } catch (e: any) {
        res.status(500).json({ success: false, error: e.message });
    }
});

// Get all invoices from FA
app.get('/fa/invoices', async (req: Request, res: Response) => {
    const FaClient = (await import('./integrations/frontAccounting/faClient')).default;
    const { config } = await import('./config');
    const faClient = new FaClient(config.faBaseUrl, config.faApiKey);
    try {
        const result = await faClient.request('GET', 'invoices');
        res.json({ success: true, result });
    } catch (e: any) {
        logger.error(`FA invoices error: ${e.message}`);
        res.status(500).json({ success: false, error: e.message });
    }
});

// Get all suppliers from FA
app.get('/fa/suppliers', async (req: Request, res: Response) => {
    const FaClient = (await import('./integrations/frontAccounting/faClient')).default;
    const { config } = await import('./config');
    const faClient = new FaClient(config.faBaseUrl, config.faApiKey);
    try {
        const result = await faClient.getSuppliers();
        res.json({ success: true, result });
    } catch (e: any) {
        logger.error(`FA suppliers error: ${e.message}`);
        res.status(500).json({ success: false, error: e.message });
    }
});

// Get all items from FA
app.get('/fa/items', async (req: Request, res: Response) => {
    const FaClient = (await import('./integrations/frontAccounting/faClient')).default;
    const { config } = await import('./config');
    const faClient = new FaClient(config.faBaseUrl, config.faApiKey);
    try {
        const result = await faClient.request('GET', 'items');
        res.json({ success: true, result });
    } catch (e: any) {
        logger.error(`FA items error: ${e.message}`);
        res.status(500).json({ success: false, error: e.message });
    }
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});