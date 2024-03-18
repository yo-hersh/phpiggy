<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\{HomeController, AboutController, AuthController};
use Framework\App;
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

class Routes
{
    public static function registerRoutes(App $app)
    {
        $app->get('/', [HomeController::class, 'home'], [AuthRequiredMiddleware::class]);
        $app->get('/about', [AboutController::class, 'about']);
        $app->get('/register', [AuthController::class, 'registerView'], [GuestOnlyMiddleware::class]);
        $app->post('/register', [AuthController::class, 'register'], [GuestOnlyMiddleware::class]);
        $app->get('/login', [AuthController::class, 'loginView'], [GuestOnlyMiddleware::class]);
        $app->post('/login', [AuthController::class, 'login'], [GuestOnlyMiddleware::class]);
        $app->get('/logout', [AuthController::class, 'logout'], [AuthRequiredMiddleware::class]);
    }
}
