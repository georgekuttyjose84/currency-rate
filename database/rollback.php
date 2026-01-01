<?php

require __DIR__ . '/../bootstrap/prepend.inc.php';

use App\Infrastructure\Database\Connection;

$pdo = Connection::make();

/**
 * Get last executed migration
 */
$stmt = $pdo->query(
    "SELECT id, migration FROM migrations ORDER BY id DESC LIMIT 1"
);
$last = $stmt->fetch();

if (!$last) {
    echo "No migrations to rollback\n";
    exit;
}

$file = __DIR__ . '/migrations/' . $last['migration'];

if (!file_exists($file)) {
    echo "Migration file not found: {$last['migration']}\n";
    exit;
}

$migration = require $file;

echo "Rolling back: {$last['migration']}\n";

$pdo->exec($migration['down']);

$pdo->prepare("DELETE FROM migrations WHERE id = :id")
    ->execute(['id' => $last['id']]);

echo "Rollback completed\n";
