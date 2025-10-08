<?php

namespace Tests\Utils;

use App\Utils\Errors\AppError;
use App\Utils\Errors\ValidationError;
use App\Utils\Errors\NotFoundError;
use App\Utils\Errors\DatabaseError;
use App\Utils\Errors\OcrError;
use App\Utils\Errors\FileUploadError;
use App\Utils\Errors\ApiError;
use App\Utils\Errors\ParsingError;
use PHPUnit\Framework\TestCase;

class ManualErrorsTest extends TestCase
{
    public function testErrorClasses(): void
    {
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
            $this->assertInstanceOf(AppError::class, $error);
            $this->assertNotEmpty($error->name);
            $this->assertNotEmpty($error->getMessage());
        }
    }
}
