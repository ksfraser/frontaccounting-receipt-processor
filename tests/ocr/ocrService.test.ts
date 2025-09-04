import { OcrService } from '../../src/ocr/ocrService';

describe('OcrService', () => {
    let ocrService: OcrService;

    beforeEach(() => {
        ocrService = new OcrService();
    });

    it('should process a PDF receipt and return extracted text', async () => {
        const pdfReceiptPath = 'path/to/test/receipt.pdf';
        const extractedText = await ocrService.processReceipt(pdfReceiptPath);
        expect(extractedText).toBeDefined();
        expect(extractedText).toContain('Expected text from receipt');
    });

    it('should process a JPG receipt and return extracted text', async () => {
        const jpgReceiptPath = 'path/to/test/receipt.jpg';
        const extractedText = await ocrService.processReceipt(jpgReceiptPath);
        expect(extractedText).toBeDefined();
        expect(extractedText).toContain('Expected text from receipt');
    });

    it('should throw an error for unsupported file types', async () => {
        const unsupportedFilePath = 'path/to/test/receipt.txt';
        await expect(ocrService.processReceipt(unsupportedFilePath)).rejects.toThrow('Unsupported file type');
    });
});