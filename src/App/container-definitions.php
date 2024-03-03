<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\ValidatorService;
use Framework\Database;

return [
    TemplateEngine::class => fn () => new TemplateEngine(paths::VIEW),
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn () => new Database(
        'mysql',
        [
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'phpiggy',
        ],
        'root',
        ''
    )
];
