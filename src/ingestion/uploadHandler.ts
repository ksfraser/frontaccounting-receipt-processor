import { Request, Response } from 'express';
import multer, { StorageEngine } from 'multer';
import path from 'path';
import fs from 'fs';
import { OcrService } from '../ocr/ocrService';
import { ReceiptParser } from '../parsing/receiptParser';
import FaClient from '../integrations/frontAccounting/faClient';
import { config } from '../config';
import { FileUploadError, ApiError, ParsingError } from '../utils/errors';

// Configure multer for file uploads
const storage: StorageEngine = multer.diskStorage({
    destination: (req: Request, file: Express.Multer.File, cb: (error: Error | null, destination: string) => void) => {
        const uploadDir = path.join(__dirname, '../../uploads');
        if (!fs.existsSync(uploadDir)) {
            fs.mkdirSync(uploadDir);
        }
        cb(null, uploadDir);
    },
    filename: (req: Request, file: Express.Multer.File, cb: (error: Error | null, filename: string) => void) => {
        cb(null, `${Date.now()}-${file.originalname}`);
    }
});

const upload = multer({ storage });
class UploadHandler {
    private ocr = new OcrService();
    private parser = new ReceiptParser();
    private faClient = new FaClient(config.faBaseUrl, config.faApiKey);

    public handleUpload = (req: Request, res: Response) => {
        upload.single('receipt')(req, res, async (err: any) => {
            if (err) {
                const error = new FileUploadError('File upload failed');
                return res.status(500).json({ message: error.message, error: err });
            }
            if (!req.file) {
                const error = new FileUploadError('No file uploaded');
                return res.status(400).json({ message: error.message });
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
                        try {
                            attachmentResult = await this.faClient.attachFileToInvoice(faResult.id, filePath);
                        } catch (attachErr: any) {
                            attachmentResult = { error: attachErr.message };
                        }
                    } else {
                        faResult.filePath = filePath;
                    }
                } catch (faErr: any) {
                    const error = new ApiError('Failed to sync with Front Accounting');
                    return res.status(502).json({ message: error.message, error: faErr.message });
                }

                return res.status(200).json({ message: 'File processed and synced', parsed, faResult, attachmentResult });
            } catch (e: any) {
                const error = new ParsingError('Processing failed');
                return res.status(500).json({ message: error.message, error: e.message });
            }
        });
    };
}

export const uploadHandler = new UploadHandler();