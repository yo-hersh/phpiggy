<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\{HomeController, AboutController, RegisterController};
use Framework\App;

class Routes
{
    public static function registerRoutes(App $app)
    {
        $app->get('/', [HomeController::class, 'home']);
        $app->get('/about', [AboutController::class, 'about']);
        $app->get('/register', [RegisterController::class, 'register']);
    }
}
