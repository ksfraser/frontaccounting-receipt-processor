# FileWatcher Documentation

## Overview
The `FileWatcher` class monitors a directory for new receipt files and processes them using OCR and parsing services. It is designed to work with the following dependencies:

- `OcrService`: Handles OCR processing of receipt files.
- `ReceiptParser`: Parses the OCR output into structured data.

## Class Diagram
Refer to the UML diagram below for the structure of the `FileWatcher` class:

![FileWatcher UML Diagram](uml/file_watcher_diagram.puml)

## Methods

### `__construct(string $receiptsDir, OcrService $ocrService, ReceiptParser $receiptParser)`
Initializes the `FileWatcher` with the directory to monitor and its dependencies.

#### Parameters:
- `string $receiptsDir`: The directory to monitor for receipt files.
- `OcrService $ocrService`: The OCR service instance.
- `ReceiptParser $receiptParser`: The receipt parser instance.

### `start(): void`
Starts monitoring the directory for new receipt files. Processes each file using OCR and parsing services.

#### Exceptions:
- Throws `Exception` if the directory does not exist.

## Example Usage
```php
$ocrService = new OcrService();
$receiptParser = new ReceiptParser();
$fileWatcher = new FileWatcher('/path/to/receipts', $ocrService, $receiptParser);

$fileWatcher->start();
```

## Testing
The `FileWatcher` class is tested using PHPUnit. Tests include scenarios for:
- Valid receipt files.
- Missing directory errors.
