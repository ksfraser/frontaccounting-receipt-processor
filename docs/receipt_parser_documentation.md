# ReceiptParser Documentation

## Overview
The `ReceiptParser` class is responsible for parsing OCR output from receipts and converting it into structured data. It uses the following classes to represent the parsed data:

- `ParsedSupplier`: Represents supplier information.
- `ParsedItem`: Represents individual items on the receipt.
- `ParsedReceipt`: Represents the entire receipt, including supplier, items, and totals.

## Class Diagram
Refer to the UML diagram below for the structure of the `ReceiptParser` and related classes:

![ReceiptParser UML Diagram](uml/receipt_parser_diagram.puml)

## Methods

### `parse(string $ocrOutput): ParsedReceipt`
Parses the OCR output and returns a `ParsedReceipt` object.

#### Parameters:
- `string $ocrOutput`: The raw OCR output from the receipt.

#### Returns:
- `ParsedReceipt`: The structured representation of the receipt.

#### Exceptions:
- Throws `Exception` if the OCR output is empty or in an invalid format.

## Example Usage
```php
$parser = new ReceiptParser();
$ocrOutput = "Supplier: ABC Corp\nDate: 2025-10-05\nItems:\n- Item A: $10.00\n- Item B: $20.00";
$parsedReceipt = $parser->parse($ocrOutput);

echo $parsedReceipt->totalAmount; // Outputs: 30.0
```

## Testing
The `ReceiptParser` class is thoroughly tested using PHPUnit. Refer to the `ReceiptParserTest` class for test cases.
