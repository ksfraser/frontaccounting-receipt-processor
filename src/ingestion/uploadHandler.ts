import { Request, Response } from 'express';
import multer from 'multer';
import path from 'path';
import fs from 'fs';
import { OcrService } from '../ocr/ocrService';
import { ReceiptParser } from '../parsing/receiptParser';
import FaClient from '../integrations/frontAccounting/faClient';
import { config } from '../config';

// Configure multer for file uploads
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        const uploadDir = path.join(__dirname, '../../uploads');
        if (!fs.existsSync(uploadDir)) {
            fs.mkdirSync(uploadDir);
        }
        cb(null, uploadDir);
    },
    filename: (req, file, cb) => {
        cb(null, `${Date.now()}-${file.originalname}`);
    }
});

const upload = multer({ storage });
class UploadHandler {
    private ocr = new OcrService();
    private parser = new ReceiptParser();
    private faClient = new FaClient(config.faBaseUrl, config.faApiKey);

    public handleUpload = (req: Request, res: Response) => {
        upload.single('receipt')(req, res, async (err) => {
            if (err) {
                return res.status(500).json({ message: 'File upload failed', error: err });
            }
            if (!req.file) {
                return res.status(400).json({ message: 'No file uploaded' });
            }
            const filePath = (req.file as Express.Multer.File).path;
            try {
                const text = await this.ocr.processReceipt(filePath);
                const parsed = this.parser.parse(text);

                // Map parsed data to FA API types
                const invoicePayload = {
                    supplierId: parsed.supplier.id,
                    items: parsed.items.map(item => ({
                        itemId: item.id,
                        quantity: item.quantity,
                        price: item.price
                    })),
                    totalAmount: parsed.totalAmount,
                    date: parsed.date
                };

                // Sync to FA
                let faResult = null;
                let attachmentResult = null;
                try {
                    faResult = await this.faClient.createInvoice(invoicePayload);

                    // Attempt to attach the file to the created invoice
                    if (faResult && faResult.id && this.faClient.attachFileToInvoice) {
                        // If FA API supports file attachment
                        try {
                            attachmentResult = await this.faClient.attachFileToInvoice(faResult.id, filePath);
                        } catch (attachErr: any) {
                            // Log but do not fail the whole request
                            attachmentResult = { error: attachErr.message };
                        }
                    } else {
                        // If not supported, include file path/URL in invoice payload
                        faResult.filePath = filePath;
                    }
                } catch (faErr: any) {
                    return res.status(502).json({ message: 'Failed to sync with Front Accounting', error: faErr.message });
                }

                return res.status(200).json({ message: 'File processed and synced', parsed, faResult, attachmentResult });
            } catch (e: any) {
                return res.status(500).json({ message: 'Processing failed', error: e.message });
            }
        });
    };
}

export const uploadHandler = new UploadHandler();