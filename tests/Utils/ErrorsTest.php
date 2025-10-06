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

class ErrorsTest extends TestCase
{
    public function testAppError(): void
    {
        $error = new AppError("An application error occurred");
        $this->assertEquals("An application error occurred", $error->getMessage());
    }

    public function testValidationError(): void
    {
        $error = new ValidationError("Validation failed");
        $this->assertEquals("Validation failed", $error->getMessage());
    }

    public function testNotFoundError(): void
    {
        $error = new NotFoundError("Resource not found");
        $this->assertEquals("Resource not found", $error->getMessage());
    }

    public function testDatabaseError(): void
    {
        $error = new DatabaseError("Database connection failed");
        $this->assertEquals("Database connection failed", $error->getMessage());
    }

    public function testOcrError(): void
    {
        $error = new OcrError("OCR processing failed");
        $this->assertEquals("OCR processing failed", $error->getMessage());
    }

    public function testFileUploadError(): void
    {
        $error = new FileUploadError("File upload failed");
        $this->assertEquals("File upload failed", $error->getMessage());
    }

    public function testApiError(): void
    {
        $error = new ApiError("API request failed");
        $this->assertEquals("API request failed", $error->getMessage());
    }

    public function testParsingError(): void
    {
        $error = new ParsingError("Parsing failed");
        $this->assertEquals("Parsing failed", $error->getMessage());
    }
}
