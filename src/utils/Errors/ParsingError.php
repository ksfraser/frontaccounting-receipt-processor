<?php

namespace App\Utils\Errors;

use App\Utils\Errors\ErrorInterface;

class ParsingError extends AppError implements ErrorInterface
{
    public $name = "ParsingError";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
