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
            $formData = $_POST;
            $excludedFields = [
                'password',
                'confirm_password',
            ];
            $formData = array_diff_key($formData, array_flip($excludedFields));

            $_SESSION['flash'] = [
                'errors' => $e->errors,
                'oldFormData' => $formData
            ];
            $referer = $_SERVER['HTTP_REFERER'];
            redirectTo($referer);
        }
    }
}
