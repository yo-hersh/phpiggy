<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller): void
    {
        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $path);

        $this->routes[] = [
            'path' => $this->normalizePath($path),
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath
        ];
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}";
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path;
    }

    public function dispatch(string $method, string $path, Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['regexPath']}$#", $path, $paramValues) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            $params = $this->getParams($route, $paramValues);

            [$class, $function] = $route['controller'];

            $controllerInstance = $container ?
                $container->resolve($class) :
                new $class;

            //middleware which is added last is run first, so it's depends in app needs 
            $allMiddleware = [...$route['middlewares'], ...$this->middlewares];

            $action = fn() => $controllerInstance->{$function}($params);

            foreach ($allMiddleware as $middleware) {
                $middleware = $container ?
                    $container->resolve($middleware) :
                    new $middleware;
                $action = fn() => $middleware->process($action);
            }
            $action();

            return;
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function addRouteMiddleware(string $middleware)
    {
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
    }

    private function getParams(array $route, array $paramValues)
    {
        array_shift($paramValues);
        preg_match_all('#{([^/]+)}#', $route['path'], $paramKeys);

        $paramKeys = $paramKeys[1];
        $params = array_combine($paramKeys, $paramValues);

        return $params;
    }

}
