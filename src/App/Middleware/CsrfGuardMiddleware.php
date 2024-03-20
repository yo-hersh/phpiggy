<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\ForbiddenException;
use Framework\Contracts\MiddlewareInterface;

class CsrfGuardMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        $validMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];

        if (!in_array($requestMethod, $validMethods)) {
            $next();
            return;
        }

        if ($_SESSION['csrfToken'] !== $_POST['csrf_token']) {
            throw new ForbiddenException();
        }

        unset($_POST['csrfToken']);

        $next();
    }
}
