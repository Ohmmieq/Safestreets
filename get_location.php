<?php
header('Content-Type: application/json');

$dbFile = __DIR__ . '/database.db';

try {
    $conn = new PDO("sqlite:$dbFile");
    $rows = $conn->query("SELECT * FROM locations ORDER BY added DESC")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
} catch (Exception $e) {
    echo json_encode([]);
}
?>