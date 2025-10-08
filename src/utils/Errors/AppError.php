<?php

namespace App\Utils\Errors;

use Exception;
use App\Utils\Errors\ErrorInterface;

class AppError extends Exception implements ErrorInterface
{
    public $name = "AppError";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    // No additional methods are needed as Exception already provides the required functionality.
}
