<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Middleware\{
    FlashMiddleware,
    JwtAuthMiddleware,
    SessionMiddleware,
    TemplateDataMiddleware,
    ValidationExceptionMiddleware
};

class Middleware
{
    static function registerMiddleware(App $app)
    {
        /*
        Middleware order is crucial:

        1. The last added middleware is the first to process 
           since each middleware calls the next one
           and the code runs and returns through the middleware stack.

        2. The first middleware to process the request will be the last to process the response.
        
        3. The session middleware should be the first one to handle the request.

        */
        $app->addMiddleware(TemplateDataMiddleware::class);
        $app->addMiddleware(ValidationExceptionMiddleware::class);
        $app->addMiddleware(FlashMiddleware::class);
        $app->addMiddleware(JwtAuthMiddleware::class);
        $app->addMiddleware(SessionMiddleware::class);
    }
}
