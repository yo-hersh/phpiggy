<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\{HomeController, AboutController, AuthController, TransactionController};
use Framework\App;
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware, TransactionsCountMiddleware};

class Routes
{
    public static function registerRoutes(App $app)
    {
        $app->get('/', [HomeController::class, 'home'], [AuthRequiredMiddleware::class, TransactionsCountMiddleware::class]);
        $app->get('/about', [AboutController::class, 'about']);
        $app->get('/register', [AuthController::class, 'registerView'], [GuestOnlyMiddleware::class]);
        $app->post('/register', [AuthController::class, 'register'], [GuestOnlyMiddleware::class]);
        $app->get('/login', [AuthController::class, 'loginView'], [GuestOnlyMiddleware::class]);
        $app->post('/login', [AuthController::class, 'login'], [GuestOnlyMiddleware::class]);
        $app->get('/logout', [AuthController::class, 'logout'], [AuthRequiredMiddleware::class]);
        $app->get('/transaction', [TransactionController::class, 'createView'], [AuthRequiredMiddleware::class]);
        $app->post('/transaction', [TransactionController::class, 'create'], [AuthRequiredMiddleware::class]);
        $app->get('/transaction/{transaction}', [TransactionController::class, 'editView'], [AuthRequiredMiddleware::class]);
    }
}
