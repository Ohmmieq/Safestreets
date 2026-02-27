<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id || !is_numeric($id)) {
  echo json_encode(['success' => false, 'error' => 'Invalid ID']);
  exit;
}

$dbFile = __DIR__ . '/database.db';

try {
  $conn = new PDO("sqlite:$dbFile");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->prepare("DELETE FROM locations WHERE id = ?");
  $stmt->execute([$id]);

  echo json_encode(['success' => true]);
} catch (Exception $e) {
  echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>