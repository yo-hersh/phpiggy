<?php

namespace App\Middleware;

use App\Auth\JwtStrategy;
// use Framework\Contracts\AuthStrategyInterface;
use Framework\Exceptions\AuthException;
use Framework\Router;
use Framework\Contracts\MiddlewareInterface;

class JwtAuthMiddleware implements MiddlewareInterface
{
    private JwtStrategy $authStrategy;
    private Router $router;

    public function __construct(JwtStrategy $authStrategy, Router $router)
    {
        $this->authStrategy = $authStrategy;
        $this->router = $router;
    }

    public function process(callable $next)
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $routes = $this->router->getRoutes();

        if (!empty($routes[$requestUri]['rules'])) {
            $credentials = $this->getCredentialsFromRequest();

            if (
                !in_array(
                    $this->authStrategy->getPermissions($credentials),
                    $routes[$requestUri]['rules']
                )
            ) {
                throw new AuthException('Authorization needed');
            }
        }

        $next();
    }


    private function getCredentialsFromRequest()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return [];
        }

        return  $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    }
}
