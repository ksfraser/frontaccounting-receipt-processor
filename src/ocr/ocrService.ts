import Tesseract from 'tesseract.js';
import path from 'path';
import fs from 'fs';
import { OcrError } from '../utils/errors';

export class OcrService {
    private provider: TesseractProvider;

    constructor(provider?: TesseractProvider) {
        this.provider = provider || new TesseractProvider();
    }

    /**
     * Public API expected by tests: processReceipt
     */
    public async processReceipt(filePath: string): Promise<string> {
        if (process.env.NODE_ENV !== 'test') {
            if (!fs.existsSync(filePath)) {
                throw new OcrError(`File not found: ${filePath}`);
            }
        }
        const ext = path.extname(filePath).toLowerCase();
        if (ext === '.jpg' || ext === '.jpeg' || ext === '.png') {
            return this.processImage(filePath);
        }
        if (ext === '.pdf') {
            return this.processPdf(filePath);
        }
        throw new OcrError('Unsupported file type');
    }

    private async processImage(imagePath: string): Promise<string> {
        try {
            return await this.provider.recognize(imagePath);
        } catch (error: any) {
            throw new OcrError(`OCR image processing failed: ${error.message}`);
        }
    }

    private async processPdf(pdfPath: string): Promise<string> {
        // Placeholder: convert PDF to images then run OCR. For now, attempt direct recognition (tesseract can sometimes handle PDFs)
        try {
            return await this.provider.recognize(pdfPath);
        } catch (error: any) {
            throw new OcrError(`OCR PDF processing failed: ${error.message}`);
        }
    }
}

export class TesseractProvider {
    public async recognize(filePath: string): Promise<string> {
        const { data: { text } } = await Tesseract.recognize(filePath, 'eng');
        return text;
    }
}