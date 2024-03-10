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
        $token = $_SESSION['token'] ?? null;

        $this->router->dispatch($method, $path, $this->container);
    }

    public function get(string $path, array $controller, bool $protected = false)
    {
        $this->router->add('GET', $path, $controller, $protected);
    }

    public function post(string $path, array $controller, bool $protected = false)
    {
        $this->router->add('POST', $path, $controller, $protected);
    }

    public function addMiddleware(string $middleware)
    {
        $this->router->addMiddleware($middleware);
    }
}
