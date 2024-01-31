<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\validationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        $next();
        // try {
        //     return $next();
        // } catch (validationException $e) {
        //     return $e->getCode();
        // }
    }
}
