<?php
$dbFile = __DIR__ . '/database.db';
$conn = new PDO("sqlite:$dbFile");
$id = intval($_GET['id']);
$conn->exec("DELETE FROM locations WHERE id = $id");
echo json_encode(['status' => 'deleted']);
?>