import path from 'path';
import chokidar from 'chokidar';
import { OcrService } from '../ocr/ocrService';
import { ReceiptParser } from '../parsing/receiptParser';

class FileWatcher {
    private watcher: chokidar.FSWatcher | null = null;
    private ocr = new OcrService();
    private parser = new ReceiptParser();
    private receiptsDir = path.join(__dirname, '../../receipts');

    public start() {
        if (this.watcher) return; // already started
        this.watcher = chokidar.watch(this.receiptsDir, {
            persistent: true,
            ignored: /(^|[\/\\])\../,
            ignoreInitial: true,
        });

        this.watcher.on('add', async (filePath: string) => {
            const extname = path.extname(filePath).toLowerCase();
            if (['.pdf', '.jpg', '.jpeg', '.png'].includes(extname)) {
                console.log(`New receipt detected: ${filePath}`);
                try {
                    const text = await this.ocr.processReceipt(filePath);
                    const parsed = this.parser.parse(text);
                    console.log('Parsed receipt', parsed);
                } catch (e: any) {
                    console.error('Failed to process new receipt', e.message);
                }
            }
        });
        console.log(`Watching for new receipts in ${this.receiptsDir}`);
    }
}

export const fileWatcher = new FileWatcher();