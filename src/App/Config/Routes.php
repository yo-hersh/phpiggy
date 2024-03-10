<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\{HomeController, AboutController, AuthController};
use Framework\App;

class Routes
{
    public static function registerRoutes(App $app)
    {
        $app->get('/', [HomeController::class, 'home'], true);
        $app->get('/about', [AboutController::class, 'about']);
        $app->get('/register', [AuthController::class, 'registerView']);
        $app->post('/register', [AuthController::class, 'register']);
        $app->get('/login', [AuthController::class, 'loginView']);
        $app->post('/login', [AuthController::class, 'login']);
    }
}
