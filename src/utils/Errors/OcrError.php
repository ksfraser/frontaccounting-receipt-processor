<?php

namespace App\Utils\Errors;

use App\Utils\Errors\ErrorInterface;

class OcrError extends AppError implements ErrorInterface
{
    public $name = "OcrError";

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
