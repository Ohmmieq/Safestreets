<?php
header('Content-Type: application/json');

$dbFile = __DIR__ . '/database.db';

try {
    $conn = new PDO("sqlite:$dbFile");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE TABLE IF NOT EXISTS locations (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        latitude REAL NOT NULL,
        longitude REAL NOT NULL,
        plate TEXT,
        details TEXT,
        media_path TEXT,
        added DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'DB error']);
    exit;
}

$lat = $_POST['latitude'] ?? null;
$lon = $_POST['longitude'] ?? null;
$plate = $_POST['plate'] ?? '';
$details = $_POST['details'] ?? '';

$mediaPath = null;
if (isset($_FILES['media']) && $_FILES['media']['error'] === 0) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $ext = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
    $mediaPath = 'uploads/' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['media']['tmp_name'], $mediaPath);
}

$stmt = $conn->prepare("INSERT INTO locations (latitude, longitude, plate, details, media_path) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$lat, $lon, $plate, $details, $mediaPath]);

echo json_encode(['status' => 'success']);
?>