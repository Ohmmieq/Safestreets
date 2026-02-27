<?php
// SQLite database – one file, no server needed
$dbFile = __DIR__ . '/database.db';

try {
    $conn = new PDO("sqlite:$dbFile");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("SQLite connection failed: " . $e->getMessage());
}

// Create table if missing
$conn->exec("
    CREATE TABLE IF NOT EXISTS locations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        latitude REAL NOT NULL,
        longitude REAL NOT NULL,
        added DATETIME DEFAULT CURRENT_TIMESTAMP
    )
");
?>