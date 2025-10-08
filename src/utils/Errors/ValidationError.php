<?php

namespace App\Utils\Errors;

use App\Utils\Errors\ErrorInterface;

class ValidationError extends AppError implements ErrorInterface
{
    public $name = "ValidationError";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
