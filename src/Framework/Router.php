<?php

declare(strict_types=1);

namespace Framework;

use Framework\Exceptions\AuthException;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller, bool $protected): void
    {
        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method),
            'controller' => $controller,
            'protected' => $protected,
        ];
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path;
    }

    public function dispatch(string $method, string $path, Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                continue;
            }
            [$class, $function] = $route['controller'];

            if ($route['protected']) {
                throw new AuthException();
            }

            $controllerInstance = $container ?
                $container->resolve($class) :
                new $class;

            $action = fn () => $controllerInstance->{$function}();

            foreach ($this->middlewares as $middleware) {
                $middleware = $container ?
                    $container->resolve($middleware) :
                    new $middleware;
                $action = fn () => $middleware->process($action);
            }
            $action();

            return;
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}
