# Front Accounting Receipt Processor

This project is designed to process PDF and JPG receipts into supplier invoices for Front Accounting. It includes features for creating new items, tracking usage and prices, and aims to automate budget entries in the future.

## Features

- **Receipt Ingestion**: Monitors directories for new receipts and triggers processing.
- **Optical Character Recognition (OCR)**: Utilizes OCR technology to extract text from receipts.
- **Data Parsing**: Extracts relevant information from OCR output, including supplier and item details.
- **Supplier Management**: Manages supplier data and interactions.
- **Item Management**: Handles creation, updates, and retrieval of items.
- **Pricing Tracking**: Tracks item prices over time and provides projections.
- **Usage Tracking**: Monitors item usage and offers long-term projections.
- **Invoice Generation**: Constructs supplier invoices based on processed receipts.
- **Budget Automation**: Automates budget entry creation based on usage and pricing data.
- **Integration with Front Accounting**: Facilitates API interactions with Front Accounting for seamless data synchronization.

## Project Structure

```
frontaccounting-receipt-processor
├── src
│   ├── index.ts                 # Main TypeScript application entry
│   ├── budget/
│   │   └── budgetEstimator.ts
│   ├── config/
│   │   └── index.ts
│   ├── ingestion/
│   │   ├── fileWatcher.ts
│   │   └── uploadHandler.ts
│   ├── integrations/
│   │   └── frontAccounting/
│   │       ├── apiTypes.ts
│   │       └── faClient.ts
│   ├── invoices/
│   │   └── invoiceBuilder.ts
│   ├── items/
│   │   └── itemService.ts
│   ├── normalization/
│   │   ├── currency.ts
│   │   └── units.ts
│   ├── ocr/
│   │   ├── ocrService.ts
│   │   └── providers/
│   │       └── tesseractProvider.ts
│   ├── parsing/
│   │   ├── receiptParser.ts
│   │   └── mappers/
│   │       ├── itemMapper.ts
│   │       └── supplierMapper.ts
│   ├── pricing/
│   │   └── priceTracker.ts
│   ├── storage/
│   │   ├── repository.ts
│   │   └── models/
│   │       ├── Invoice.ts
│   │       ├── Item.ts
│   │       ├── PricePoint.ts
│   │       └── Supplier.ts
│   ├── suppliers/
│   │   └── supplierService.ts
│   ├── types/
│   │   └── index.ts
│   ├── usage/
│   │   └── usageTracker.ts
│   └── utils/
│       ├── errors.ts
│       └── logger.ts
├── tests
│   ├── Unit/
│   ├── ocr/
│   ├── parsing/
│   └── ...
├── scripts
│   ├── seedDemoData.ts
│   └── syncFrontAccounting.ts
├── docs
│   ├── api.md
│   ├── architecture.md
│   └── roadmap.md
├── config
│   ├── default.json
│   ├── development.json
│   └── production.json
├── composer.json
├── package.json
├── tsconfig.json
├── jest.config.js
├── phpunit.xml
├── Dockerfile
├── docker-compose.yml
├── README.md
└── LICENSE
```

## Getting Started

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/frontaccounting-receipt-processor.git
   ```

2. Navigate to the project directory:
   ```
   cd frontaccounting-receipt-processor
   ```

3. Install PHP dependencies:
   ```
   composer install
   ```

4. Install Node.js dependencies:
   ```
   npm install
   ```

5. Configure environment variables by copying `.env.example` to `.env` and updating the values.

6. Build the TypeScript code:
   ```
   npm run build
   ```

7. Start the application:
   ```
   npm start
   ```

8. Run tests:
   ```
   composer test
   ```

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.