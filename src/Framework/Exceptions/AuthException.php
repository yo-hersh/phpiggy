<?php

namespace Framework\Exceptions;

use RuntimeException;

class AuthException extends RuntimeException
{
    public function __construct(int $code = 401)
    {
        parent::__construct(code: $code);
    }
}
