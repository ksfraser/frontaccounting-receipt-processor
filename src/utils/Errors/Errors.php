<?php

namespace App\Utils\Errors;

class AppError extends \Exception
{
    public string $name;

    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'AppError';
    }
}

class ValidationError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'ValidationError';
    }
}

class NotFoundError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'NotFoundError';
    }
}

class DatabaseError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'DatabaseError';
    }
}

class OcrError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'OcrError';
    }
}

class FileUploadError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'FileUploadError';
    }
}

class ApiError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'ApiError';
    }
}

class ParsingError extends AppError
{
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->name = 'ParsingError';
    }
}
