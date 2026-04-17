<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/password_reset_helpers.php';

ensure_password_reset_table($conn);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$token = trim($data['token'] ?? '');
$password = $data['password'] ?? '';
$confirmPassword = $data['confirm_password'] ?? '';

if ($token === '') {
    echo json_encode(['status' => 'error', 'message' => 'Missing reset token.']);
    exit();
}

if (strlen($password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters.']);
    exit();
}

if ($password !== $confirmPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
    exit();
}

$reset = find_valid_reset_token($conn, $token);

if (!$reset) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or expired reset link.']);
    exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, 'UPDATE users SET password = ? WHERE id = ?');
$userId = (int) $reset['user_id'];
mysqli_stmt_bind_param($stmt, 'si', $hash, $userId);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$ok) {
    echo json_encode(['status' => 'error', 'message' => 'Could not update password.']);
    exit();
}

mark_reset_token_used($conn, (int) $reset['id']);

echo json_encode(['status' => 'success']);
