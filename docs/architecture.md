# Architecture of the Front Accounting Receipt Processor

## Overview
The Front Accounting Receipt Processor is designed to automate the conversion of PDF and JPG receipts into supplier invoices. The application leverages Optical Character Recognition (OCR) technology to extract relevant data from receipts, processes this data, and integrates with Front Accounting for invoice management.

## Components

### 1. Ingestion
- **FileWatcher**: Monitors a specified directory for new receipt files (PDF, JPG, PNG) and triggers processing when new files are detected. It integrates with the `OcrService` for text extraction and the `ReceiptParser` for data processing.
- **UploadHandler**: Manages the uploading of receipts and initiates the processing workflow.

### 2. Optical Character Recognition (OCR)
- **OcrService**: Provides methods for performing OCR on receipts to extract text data.
- **TesseractProvider**: Implements OCR functionality using the Tesseract library, enabling text extraction from images.

### 3. Parsing
- **ReceiptParser**: Processes the OCR output to extract relevant information such as supplier details and itemized lists.
- **Mappers**:
  - **SupplierMapper**: Maps supplier data from the parsed receipt to the application's supplier model.
  - **ItemMapper**: Maps item data from the parsed receipt to the application's item model.

### 4. Normalization
- **Currency**: Functions for normalizing various currency formats found in receipts.
- **Units**: Functions for normalizing measurement units to ensure consistency across the application.

### 5. Suppliers
- **SupplierService**: Manages supplier data, including creation, updates, and retrieval of supplier information.

### 6. Items
- **ItemService**: Handles the creation, updates, and retrieval of items within the application.

### 7. Pricing
- **PriceTracker**: Tracks item prices over time and provides projections for budgeting and forecasting.

### 8. Usage Tracking
- **UsageTracker**: Monitors item usage and provides long-term projections to assist in inventory management.

### 9. Invoices
- **InvoiceBuilder**: Constructs supplier invoices based on the processed receipt data, ensuring accurate billing.

### 10. Budgeting
- **BudgetEstimator**: Automates the creation of budget entries based on usage and pricing data, facilitating financial planning.

### 11. Integrations
- **FaClient**: Handles API interactions with Front Accounting, ensuring seamless data synchronization.
- **ApiTypes**: Defines types and interfaces used for API communication with Front Accounting.

### 12. Storage
- **Repository**: Manages data storage and retrieval for items, suppliers, invoices, and price points.
- **Models**: Defines the data models for Item, Supplier, Invoice, and PricePoint.

### 13. Utilities
- **Logger**: A utility for logging application events and errors, aiding in debugging and monitoring.
- **Errors**: Custom error classes for handling application-specific errors.

## Future Enhancements
The project aims to enhance its capabilities by:
- Implementing advanced machine learning techniques for improved OCR accuracy.
- Expanding the integration with Front Accounting to include more features.
- Developing a user-friendly interface for managing receipts and invoices.
- Automating additional financial processes to streamline accounting workflows.

## Conclusion
The Front Accounting Receipt Processor is a comprehensive solution for automating the conversion of receipts into invoices, leveraging modern technologies to enhance efficiency and accuracy in financial management.