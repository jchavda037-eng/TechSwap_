<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/password_reset_helpers.php';
require_once __DIR__ . '/smtp_mailer.php';

ensure_password_reset_table($conn);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
    exit();
}

$user = find_user_by_email($conn, $email);

// Do not reveal whether the email exists.
if (!$user) {
    echo json_encode(['status' => 'success']);
    exit();
}

$token = create_password_reset_token($conn, (int) $user['id']);
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$resetUrl = $scheme . '://' . $host . $basePath . '/forgot_password.php?token=' . urlencode($token);

$subject = 'TechSwap password reset';
$message = "Hello {$user['name']},\r\n\r\n"
    . "Use this link to reset your TechSwap password:\r\n"
    . $resetUrl . "\r\n\r\n"
    . "This link expires in 1 hour.\r\n\r\n"
    . "If you did not request this, you can ignore this email.";
$sent = false;
try {
    $sent = send_smtp_mail($user['email'], $subject, $message);
} catch (Throwable $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email could not be sent: ' . $e->getMessage()
    ]);
    exit();
}

echo json_encode(['status' => 'success']);
