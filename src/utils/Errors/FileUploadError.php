<?php

namespace App\Utils\Errors;

use App\Utils\Errors\ErrorInterface;

class FileUploadError extends AppError implements ErrorInterface
{
    public $name = "FileUploadError";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
