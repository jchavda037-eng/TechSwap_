<?php
header('Content-Type: application/json');

require_once __DIR__ . '/password_reset_helpers.php';

ensure_password_reset_table($conn);

$token = trim($_GET['token'] ?? '');

if ($token === '') {
    echo json_encode(['status' => 'error', 'message' => 'Missing token.']);
    exit();
}

$reset = find_valid_reset_token($conn, $token);

if (!$reset) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or expired reset link.']);
    exit();
}

echo json_encode(['status' => 'success']);
