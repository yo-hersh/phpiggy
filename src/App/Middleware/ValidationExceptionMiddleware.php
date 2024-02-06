<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidationException $e) {
            $_SESSION['flash'] = ['errors' => $e->errors];
            $referer = $_SERVER['HTTP_REFERER'];
            redirectTo($referer);
        }
        // try {
        //     return $next();
        // } catch (validationException $e) {
        //     return $e->getCode();
        // }
    }
}
