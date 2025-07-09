<?php
// migrate.php: Run all SQL migrations in the migrations directory against the SQLite database

declare(strict_types=1);

$dbPath = __DIR__ . '/database/app.db';
$migrationsDir = __DIR__ . '/migrations';

if (!file_exists(dirname($dbPath))) {
    mkdir(dirname($dbPath), 0777, true);
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $files = glob($migrationsDir . '/*.sql');
    sort($files);

    foreach ($files as $file) {
        echo "Applying migration: $file\n";
        $sql = file_get_contents($file);
        $pdo->exec($sql);
    }
    echo "All migrations applied successfully.\n";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
