<?php

declare(strict_types=1);

use App\Services\TransactionService;
use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\{ReceiptService, ValidatorService, UserService};
use Framework\Container;
use Framework\Database;

return [
    TemplateEngine::class => fn() => new TemplateEngine(paths::VIEW),
    ValidatorService::class => fn() => new ValidatorService(),
    Database::class => fn() => new Database(
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

        return new UserService($db);
    },
    TransactionService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new TransactionService($db);
    },
    ReceiptService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new ReceiptService($db);
    }

];
