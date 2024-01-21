<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

class AuthController
{
    public function __construct(private TemplateEngine $view)
    {
    }
    public function registerView()
    {
        echo $this->view->render(
            'register.php',
            [
                'title' => 'Register'
            ]
        );
    }

    public function register()
    {
        dd($_POST);
    }
}
