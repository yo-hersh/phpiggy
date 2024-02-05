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

        // the ob_end_clean is not only removes the output buffer but also turn off output buffering,
        // so, any data written after this line will be sent to the browser without being buffered,
        // which is causes an error by trying to start a session after headers have already been sent
        ob_end_clean();
        echo "here";

        if (headers_sent()) {
            throw new SessionException("Headers already sent");
        }
        session_start();
        $next();
    }
}
