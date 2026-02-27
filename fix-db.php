<?php
$dbFile = __DIR__ . '/database.db';

try {
    $conn = new PDO("sqlite:$dbFile");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add missing columns safely
    $conn->exec("ALTER TABLE locations ADD COLUMN plate TEXT");
    $conn->exec("ALTER TABLE locations ADD COLUMN details TEXT");
    $conn->exec("ALTER TABLE locations ADD COLUMN media_path TEXT");

    echo "Database fixed! Columns added: plate, details, media_path";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>