<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // allow localhost/phone access

$dbFile = __DIR__ . '/database.db';

try {
  $conn = new PDO("sqlite:$dbFile");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->query("SELECT id, latitude, longitude, plate, details, media_path, added FROM locations ORDER BY added DESC");
  $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($reports);
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
}
?>