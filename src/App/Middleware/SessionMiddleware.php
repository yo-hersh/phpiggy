<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\SessionException;
use Framework\Contracts\MiddlewareInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session already started");
        }
        ob_end_clean();
        echo "here";

        if (headers_sent()) {
            throw new SessionException("Headers already sent");
        }
        session_start();
        $next();
    }
}
