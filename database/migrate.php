<?php

require __DIR__ . '/../bootstrap/prepend.inc.php';

use App\Infrastructure\Database\Connection;

$pdo = Connection::make();

exit("Forced migration failure");

/**
 * 1. Ensure migrations table exists
 */
$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

/**
 * 2. Get already executed migrations
 */
$executed = $pdo
    ->query("SELECT migration FROM migrations")
    ->fetchAll(PDO::FETCH_COLUMN);

/**
 * 3. Load migration files
 */
$migrationFiles = glob(__DIR__ . '/migrations/*.php');
sort($migrationFiles);

foreach ($migrationFiles as $file) {
    $migrationName = basename($file);

    if (in_array($migrationName, $executed, true)) {
        continue;
    }

    echo "Running migration: {$migrationName}\n";

    $migration = require $file;

    $pdo->exec($migration['up']);

    $stmt = $pdo->prepare(
        "INSERT INTO migrations (migration) VALUES (:migration)"
    );
    $stmt->execute(['migration' => $migrationName]);
}

echo "All migrations executed\n";

