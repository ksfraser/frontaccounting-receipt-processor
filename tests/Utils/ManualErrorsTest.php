<?php

require __DIR__ . '/../../vendor/autoload.php';

use App\Utils\Errors\AppError;
use App\Utils\Errors\ValidationError;
use App\Utils\Errors\NotFoundError;
use App\Utils\Errors\DatabaseError;
use App\Utils\Errors\OcrError;
use App\Utils\Errors\FileUploadError;
use App\Utils\Errors\ApiError;
use App\Utils\Errors\ParsingError;

function testErrorClasses() {
    $errors = [
        new AppError("App error occurred"),
        new ValidationError("Validation failed"),
        new NotFoundError("Not found"),
        new DatabaseError("Database error"),
        new OcrError("OCR error"),
        new FileUploadError("File upload error"),
        new ApiError("API error"),
        new ParsingError("Parsing error"),
    ];

    foreach ($errors as $error) {
        echo get_class($error) . " - " . $error->name . " - " . $error->getMessage() . PHP_EOL;
    }
}

testErrorClasses();
