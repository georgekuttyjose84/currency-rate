<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$envFile = __DIR__ . '/../.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

