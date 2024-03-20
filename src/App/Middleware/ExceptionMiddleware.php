<?php

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

class ExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();
        } catch (\Exception $e) {
            //  log the exception or do something else here
            redirectTo('/404');
        }
    }
}
