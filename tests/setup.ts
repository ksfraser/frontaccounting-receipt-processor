/// <reference types="jest" />
// Jest setup file
// Global mocks & test configuration

// Mock tesseract.js to avoid heavy OCR work & file dependencies in tests
jest.mock('tesseract.js', () => ({
	recognize: jest.fn(async (_file: string, _lang?: string) => ({
		data: { text: 'Expected text from receipt (mocked OCR output)' }
	}))
}));

export {}; // keep as module
