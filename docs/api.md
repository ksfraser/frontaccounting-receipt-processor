# API Documentation for Front Accounting Receipt Processor

## Overview

The Front Accounting Receipt Processor is designed to automate the processing of PDF and JPG receipts into supplier invoices. This application leverages Optical Character Recognition (OCR) to extract relevant data from receipts, normalizes the data, and integrates with Front Accounting for invoice management.

## API Endpoints

### 1. Upload Receipt

- **Endpoint:** `POST /api/receipts/upload`
- **Description:** Uploads a new receipt for processing.
- **Request Body:**
  - `file`: The receipt file (PDF or JPG).
- **Response:**
  - `200 OK`: Receipt uploaded successfully.
  - `400 Bad Request`: Invalid file type or missing file.

### 2. Process Receipt

- **Endpoint:** `POST /api/receipts/process`
- **Description:** Processes the uploaded receipt and extracts data.
- **Request Body:**
  - `receiptId`: The ID of the uploaded receipt.
- **Response:**
  - `200 OK`: Receipt processed successfully, returns extracted data.
  - `404 Not Found`: Receipt not found.

### 3. Create Supplier Invoice

- **Endpoint:** `POST /api/invoices/create`
- **Description:** Creates a new supplier invoice based on processed receipt data.
- **Request Body:**
  - `supplierId`: The ID of the supplier.
  - `items`: Array of items extracted from the receipt.
- **Response:**
  - `201 Created`: Invoice created successfully.
  - `400 Bad Request`: Invalid supplier ID or items.

### 4. Track Item Usage

- **Endpoint:** `GET /api/items/usage`
- **Description:** Retrieves usage statistics for items.
- **Response:**
  - `200 OK`: Returns usage data for items.

### 5. Get Price History

- **Endpoint:** `GET /api/items/:itemId/prices`
- **Description:** Retrieves historical price data for a specific item.
- **Response:**
  - `200 OK`: Returns price history for the item.
  - `404 Not Found`: Item not found.

### 6. Budget Estimation

- **Endpoint:** `GET /api/budget/estimate`
- **Description:** Estimates budget entries based on usage and pricing data.
- **Response:**
  - `200 OK`: Returns estimated budget data.

## Error Handling

All API responses will include an error message in the following format:

```json
{
  "error": {
    "code": "ERROR_CODE",
    "message": "Detailed error message."
  }
}
```

## Authentication

The API requires authentication via API tokens. Include the token in the `Authorization` header as follows:

```
Authorization: Bearer YOUR_API_TOKEN
```

## Conclusion

This API documentation provides an overview of the endpoints available in the Front Accounting Receipt Processor. For further details on implementation and usage, please refer to the source code and additional documentation.