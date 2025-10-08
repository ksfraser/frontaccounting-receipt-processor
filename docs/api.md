# API Documentation for Front Accounting Receipt Processor

## Overview

The Front Accounting Receipt Processor is designed to automate the processing of PDF and JPG receipts into supplier invoices. This application leverages Optical Character Recognition (OCR) to extract relevant data from receipts, normalizes the data, and integrates with Front Accounting for invoice management.

## API Endpoints

### 1. Upload Receipt

- **Endpoint:** `POST /upload`
- **Description:** Uploads a new receipt for processing.
- **Request Body:**
  - `file`: The receipt file (PDF or JPG).
- **Response:**
  - `200 OK`: Receipt uploaded successfully.
  - `400 Bad Request`: Invalid file type or missing file.

### 2. Sync Supplier to FA

- **Endpoint:** `POST /fa/supplier`
- **Description:** Creates or updates a supplier in Front Accounting.
- **Request Body:**
  - Supplier data object
- **Response:**
  - `200 OK`: Supplier synced successfully.
  - `500 Internal Server Error`: Sync failed.

### 3. Sync Item to FA

- **Endpoint:** `POST /fa/item`
- **Description:** Creates or updates an item in Front Accounting.
- **Request Body:**
  - Item data object
- **Response:**
  - `200 OK`: Item synced successfully.
  - `500 Internal Server Error`: Sync failed.

### 4. Get Item Prices from FA

- **Endpoint:** `GET /fa/item/:id/prices`
- **Description:** Retrieves historical price data for a specific item from Front Accounting.
- **Response:**
  - `200 OK`: Returns price history.
  - `500 Internal Server Error`: API call failed.

### 5. Get All Invoices from FA

- **Endpoint:** `GET /fa/invoices`
- **Description:** Retrieves all invoices from Front Accounting.
- **Response:**
  - `200 OK`: Returns invoices list.
  - `500 Internal Server Error`: API call failed.

### 6. Get All Suppliers from FA

- **Endpoint:** `GET /fa/suppliers`
- **Description:** Retrieves all suppliers from Front Accounting.
- **Response:**
  - `200 OK`: Returns suppliers list.
  - `500 Internal Server Error`: API call failed.

### 7. Get All Items from FA

- **Endpoint:** `GET /fa/items`
- **Description:** Retrieves all items from Front Accounting.
- **Response:**
  - `200 OK`: Returns items list.
  - `500 Internal Server Error`: API call failed.

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