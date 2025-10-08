<?php

namespace App\Utils\Errors;

use App\Utils\Errors\ErrorInterface;

class DatabaseError extends AppError implements ErrorInterface
{
    public $name = "DatabaseError";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
