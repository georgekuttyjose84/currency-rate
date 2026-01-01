<?php

require __DIR__ . '/../bootstrap/prepend.inc.php';

use App\Infrastructure\Database\Connection;

$pdo = Connection::make();

$executed = $pdo
    ->query("SELECT id, migration FROM migrations ORDER BY id DESC")
    ->fetchAll();

foreach ($executed as $row) {
    $file = __DIR__ . '/migrations/' . $row['migration'];
    $migration = require $file;

    echo "Resetting: {$row['migration']}\n";
    $pdo->exec($migration['down']);

    $pdo->prepare("DELETE FROM migrations WHERE id = :id")
        ->execute(['id' => $row['id']]);
}

echo "Database reset completed\n";
