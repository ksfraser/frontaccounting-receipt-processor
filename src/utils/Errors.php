<?php

namespace App\Utils\Errors;

class AppError extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

class ValidationError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

class NotFoundError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

class DatabaseError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

class OcrError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

class FileUploadError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

class ApiError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}

class ParsingError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
