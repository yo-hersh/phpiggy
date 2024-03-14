<?php

declare(strict_types=1);

use Framework\{Router, TemplateEngine, Container, Database};
use App\Middleware\JwtAuthMiddleware;
use App\Config\Paths;
use App\Auth\JwtStrategy;
use App\Services\{ValidatorService, UserService};

return [
    TemplateEngine::class => fn () => new TemplateEngine(paths::VIEW),
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn () => new Database(
        $_ENV['DB_DRIVER'],
        [
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
        ],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    ),
    UserService::class => function (Container $container) {
        $db = $container->get(Database::class);
        $jwtStrategy = $container->get(JwtStrategy::class);

        return new UserService($db, $jwtStrategy);
    },
    JwtStrategy::class => fn () => new JwtStrategy(),
    JwtAuthMiddleware::class => function (Container $container) {
        $authStrategy = $container->get(JwtStrategy::class);
        $router = $container->get(Router::class);

        return new JwtAuthMiddleware($authStrategy, $router);
    },

];
