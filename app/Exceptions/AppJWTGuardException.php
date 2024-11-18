<?php

namespace App\Exceptions;

use UnexpectedValueException;

class AppJWTGuardException extends UnexpectedValueException
{
    public function __construct(string $message)
    {
        $this->message = "[APP JWT Guard] {$message}";
    }
}
