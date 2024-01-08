<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class HomeController
{
    private TemplateEngine $view;

    public function __construct()
    {
        $this->view = new TemplateEngine(paths::VIEW);
    }
    public function home()
    {
        echo $this->view->render(
            'index.php',
            [
                'username' => 'Yosef Hershkovitz',
                'title' => 'Home',
            ]
        );
    }
}
