<?php

namespace App\Presentation\Controller;

class HomeController
{
    public function index(): void
    {
        echo "App: " . getenv('APP_NAME') . "<br>";
        echo "Environment: " . getenv('APP_ENV');
    }
}


