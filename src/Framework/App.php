<?php

declare(strict_types=1);

namespace Framework;


class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $containerDefinitionsPath = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if ($containerDefinitionsPath) {
            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }

    public function run()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($method, $path, $this->container);
    }

    public function get(string $path, array $controller, array $middlewares = [])
    {
        $this->router->add('GET', $path, $controller);
        foreach ($middlewares as $middleware) {
            $this->addRouteMiddleware($middleware);
        }
    }

    public function post(string $path, array $controller, array $middlewares = [])
    {
        $this->router->add('POST', $path, $controller);
        foreach ($middlewares as $middleware) {
            $this->addRouteMiddleware($middleware);
        }
    }

    public function delete(string $path, array $controller, array $middlewares = [])
    {
        $this->router->add('DELETE', $path, $controller);
        foreach ($middlewares as $middleware) {
            $this->addRouteMiddleware($middleware);
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->router->addMiddleware($middleware);
    }

    public function addRouteMiddleware(string $middleware)
    {
        $this->router->addRouteMiddleware($middleware);
    }

    public function setErrorHandlers(array $controller)
    {
        $this->router->setErrorHandlers($controller);
    }
}
