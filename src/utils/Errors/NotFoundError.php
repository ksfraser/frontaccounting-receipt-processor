<?php

namespace App\Utils\Errors;

use App\Utils\Errors\ErrorInterface;

class NotFoundError extends AppError implements ErrorInterface
{
    public $name = "NotFoundError";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
