<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$phone = trim($data['phone'] ?? '');

if (empty($phone) || !preg_match('/^(\+254|0)7\d{8}$/', $phone)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid phone number']);
    exit;
}

$phone = preg_replace('/^0/', '+254', $phone);

$otp = rand(1000, 9999);

$username = "sandbox";
$apiKey   = "atsk_1fd6cb05d7a037106d2b00ec81ea60f3848e5502c3f60379ed8bf0aab8ea088421eea173"; // YOUR REAL KEY

$message = "Your SafeStreets OTP is $otp. Valid for 10 minutes. Do not share.";

$url = "https://api.africastalking.com/version1/messaging";

$postData = http_build_query([
    'username' => $username,
    'to'       => $phone,
    'message'  => $message,
    'from'     => 'SafeStreets'
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apiKey: $apiKey",
    "Content-Type: application/x-www-form-urlencoded"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 201) {
    echo json_encode([
        'success' => true,
        'message' => 'OTP sent',
        'otp'     => $otp  // for testing only - remove in production
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error'   => 'Failed to send OTP',
        'http_code' => $httpCode,
        'response' => $response
    ]);
}
?>