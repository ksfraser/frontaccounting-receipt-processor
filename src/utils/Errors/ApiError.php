<?php

namespace App\Utils\Errors;

use App\Utils\Errors\ErrorInterface;

class ApiError extends AppError implements ErrorInterface
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
