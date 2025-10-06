# Errors Documentation

## Overview
The `Errors` module provides a hierarchy of custom exceptions for the application. These exceptions extend the base `AppError` class and are used to represent specific error scenarios.

## Classes

### AppError
- **Description**: Base class for all application errors.
- **Constructor**: `__construct(string $message)`

### ValidationError
- **Description**: Represents validation errors.
- **Constructor**: `__construct(string $message)`

### NotFoundError
- **Description**: Represents resource not found errors.
- **Constructor**: `__construct(string $message)`

### DatabaseError
- **Description**: Represents database-related errors.
- **Constructor**: `__construct(string $message)`

### OcrError
- **Description**: Represents OCR processing errors.
- **Constructor**: `__construct(string $message)`

### FileUploadError
- **Description**: Represents file upload errors.
- **Constructor**: `__construct(string $message)`

### ApiError
- **Description**: Represents API request errors.
- **Constructor**: `__construct(string $message)`

### ParsingError
- **Description**: Represents parsing errors.
- **Constructor**: `__construct(string $message)`

## Usage
These custom exceptions can be used to handle specific error scenarios in the application. For example:

```php
try {
    throw new ValidationError("Invalid input data");
} catch (ValidationError $e) {
    echo $e->getMessage();
}
```
