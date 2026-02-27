<?php
header('Content-Type: application/json; charset=utf-8');

// only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use POST.']);
    exit;
}

// include DB connection (expects $conn)
include 'db.php';

// read JSON body or form-data
$raw = file_get_contents('php://input');
$body = $_POST ?: json_decode($raw, true);

// get coordinates from common keys
$lat = $body['latitude'] ?? $body['lat'] ?? null;
$lon = $body['longitude'] ?? $body['lng'] ?? $body['lon'] ?? null;

// validate
if (!is_numeric($lat) || !is_numeric($lon)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing latitude/longitude']);
    exit;
}

$lat = floatval($lat);
$lon = floatval($lon);
if ($lat < -90 || $lat > 90 || $lon < -180 || $lon > 180) {
    http_response_code(400);
    echo json_encode(['error' => 'Latitude or longitude out of range']);
    exit;
}

// insert safely
$stmt = $conn->prepare('INSERT INTO `locations` (`latitude`, `longitude`) VALUES (?, ?)');
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare failed', 'details' => $conn->error]);
    exit;
}

$stmt->bind_param('dd', $lat, $lon);
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Insert failed', 'details' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

$insertId = $stmt->insert_id;
$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'id' => $insertId]);
?>