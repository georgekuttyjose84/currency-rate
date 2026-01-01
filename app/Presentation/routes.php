<?php

use App\Presentation\Controller\HomeController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === '/' || $path === '') {
    (new HomeController())->index();
    return;
}

http_response_code(404);
echo '404 Not Found';
