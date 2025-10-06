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
│   ├── Ingestion
│   ├── OCR
│   ├── Parsing
│   ├── Suppliers
│   ├── Items
│   ├── Pricing
│   ├── Usage
│   ├── Invoices
│   ├── Budget
│   ├── Integrations
│   ├── Storage
│   ├── Utils
│   └── Normalization
├── tests
├── scripts
├── docs
├── config
├── Dockerfile
├── docker-compose.yml
├── composer.json
├── phpunit.xml
├── .env.example
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

3. Install dependencies:
   ```
   composer install
   ```

4. Configure environment variables by copying `.env.example` to `.env` and updating the values.

5. Start the application:
   ```
   php artisan serve
   ```

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.