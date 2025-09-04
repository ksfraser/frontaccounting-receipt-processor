class TesseractProvider {
    private tesseract: any;

    constructor() {
        this.tesseract = require('tesseract.js');
    }

    public async recognizeImage(imagePath: string): Promise<string> {
        try {
            const { data: { text } } = await this.tesseract.recognize(imagePath, 'eng');
            return text;
        } catch (error) {
            throw new Error(`Error recognizing image: ${error.message}`);
        }
    }
}

export default TesseractProvider;