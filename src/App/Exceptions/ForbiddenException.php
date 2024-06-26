<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    public function __construct()
    {
        parent::__construct('Forbidden', 403);
    }
}
