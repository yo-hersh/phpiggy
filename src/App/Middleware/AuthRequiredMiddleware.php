<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\ForbiddenException;
use Framework\Contracts\MiddlewareInterface;

class AuthRequiredMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        if (!isset($_SESSION['user'])) {
            redirectTo('/login');
        }
        $next();
    }
}
