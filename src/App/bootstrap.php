<?php

declare(strict_types=1);
include __DIR__ . '/../../vendor/autoload.php';

use Framework\App;
use App\Config\Routes;

$app = new App();

// it's no able to it because the router is a private property of the app
// it's needed to create a func to added a value to a private property
// $app->router->add('/');

Routes::registerRoutes($app);


return $app;
