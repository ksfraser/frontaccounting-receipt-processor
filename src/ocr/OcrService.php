<?php

namespace App\Ocr;

use App\Utils\Errors\OcrError;

/**
 * Interface for OCR providers.
 */
interface OcrProviderInterface
{
    /**
     * Recognizes text from the given file.
     *
     * @param string $filePath Path to the file to process.
     * @return string Recognized text.
     */
    public function recognize(string $filePath): string;
}

/**
 * Service for processing receipts using OCR.
 */
class OcrService
{
    /**
     * @var OcrProviderInterface OCR provider instance.
     */
    private OcrProviderInterface $provider;

    /**
     * Constructor.
     *
     * @param OcrProviderInterface $provider OCR provider instance.
     */
    public function __construct(OcrProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Processes a receipt file and extracts text.
     *
     * @param string $filePath Path to the receipt file.
     * @return string Extracted text from the receipt.
     * @throws OcrError If the file is not found or unsupported.
     */
    public function processReceipt(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new OcrError("File not found: {$filePath}");
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            return $this->processImage($filePath);
        }

        if ($ext === 'pdf') {
            return $this->processPdf($filePath);
        }

        throw new OcrError('Unsupported file type');
    }

    /**
     * Processes an image file and extracts text.
     *
     * @param string $imagePath Path to the image file.
     * @return string Extracted text from the image.
     * @throws OcrError If OCR processing fails.
     */
    private function processImage(string $imagePath): string
    {
        try {
            return $this->provider->recognize($imagePath);
        } catch (\Exception $e) {
            throw new OcrError("OCR image processing failed: {$e->getMessage()}");
        }
    }

    /**
     * Processes a PDF file and extracts text.
     *
     * @param string $pdfPath Path to the PDF file.
     * @return string Extracted text from the PDF.
     * @throws OcrError If OCR processing fails.
     */
    private function processPdf(string $pdfPath): string
    {
        try {
            return $this->provider->recognize($pdfPath);
        } catch (\Exception $e) {
            throw new OcrError("OCR PDF processing failed: {$e->getMessage()}");
        }
    }
}
