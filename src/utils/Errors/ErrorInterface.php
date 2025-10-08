<?php

namespace App\Utils\Errors;

interface ErrorInterface
{
    public function getMessage(): string;
    public function getCode(): int;
}
