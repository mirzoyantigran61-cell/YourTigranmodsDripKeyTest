<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in.']);
    exit;
}

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$userID = $data['userID'] ?? '';

if (empty($userID)) {
    echo json_encode(['success' => false, 'error' => 'User ID required.']);
    exit;
}

// Check limit: 1 key per external User ID per 24h
$stmt = $pdo->prepare("SELECT generated_key FROM `keys` WHERE user_id_external = ? AND created_at > NOW() - INTERVAL 24 HOUR LIMIT 1");
$stmt->execute([$userID]);
if ($existing = $stmt->fetch()) {
    echo json_encode(['success' => false, 'error' => 'Key already exists for this User ID in last 24h: ' . $existing['generated_key']]);
    exit;
}

// Generate key
$randomDigits = '';
for ($i = 0; $i < KEY_LENGTH; $i++) {
    $randomDigits .= rand(0, 9);
}
$key = KEY_PREFIX . $randomDigits;

// Save
$stmt = $pdo->prepare("INSERT INTO `keys` (user_id, user_id_external, generated_key) VALUES (?, ?, ?)");
$stmt->execute([$_SESSION['user_id'], $userID, $key]);

echo json_encode(['success' => true, 'key' => $key]);
?>
