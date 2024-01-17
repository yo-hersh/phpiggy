<?php

declare(strict_types=1);
include __DIR__ . '/../../vendor/autoload.php';

use Framework\App;
use App\Config\{Middleware, Routes, Paths};

$app = new App(paths::SOURCE . 'App/container-definitions.php');

// it's no able to it because the router is a private property of the app
// it's needed to create a func to added a value to a private property
// $app->router->add('/');

Routes::registerRoutes($app);
Middleware::registerMiddleware($app);

return $app;
