<?php

namespace App\Utils\Errors;

use Exception;
use App\Utils\Errors\ErrorInterface;

class AppError extends Exception implements ErrorInterface
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function getMessage(): string
    {
        return parent::getMessage();
    }

    public function getCode(): int
    {
        return parent::getCode();
    }
}
