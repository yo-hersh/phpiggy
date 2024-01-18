<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AboutController
{
    public function __construct(private TemplateEngine $view)
    {
        var_dump($this->view);
        echo "<br>";
    }
    public function about()
    {
        echo $this->view->render(
            'about.php',
            [
                // "title" => "About",
                "dangerousDate" => '<script>alert(123)</script>'
            ]
        );
    }
}
