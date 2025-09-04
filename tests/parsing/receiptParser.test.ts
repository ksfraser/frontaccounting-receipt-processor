import { ReceiptParser } from '../../src/parsing/receiptParser';

describe('ReceiptParser', () => {
    let parser: ReceiptParser;

    beforeEach(() => {
        parser = new ReceiptParser();
    });

    it('should correctly parse a sample receipt', () => {
        const sampleOcrOutput = `
            Supplier: ABC Supplies
            Date: 2023-10-01
            Items:
            - Item 1: $10.00
            - Item 2: $15.50
        `;

        const result = parser.parse(sampleOcrOutput);

        expect(result.supplier).toBe('ABC Supplies');
        expect(result.date).toBe('2023-10-01');
        expect(result.items.length).toBe(2);
        expect(result.items[0].name).toBe('Item 1');
        expect(result.items[0].price).toBe(10.00);
        expect(result.items[1].name).toBe('Item 2');
        expect(result.items[1].price).toBe(15.50);
    });

    it('should handle empty OCR output gracefully', () => {
        const result = parser.parse('');

        expect(result).toEqual({
            supplier: '',
            date: '',
            items: []
        });
    });

    it('should throw an error for invalid OCR output', () => {
        const invalidOcrOutput = `
            Invalid receipt format
        `;

        expect(() => parser.parse(invalidOcrOutput)).toThrow('Invalid receipt format');
    });
});