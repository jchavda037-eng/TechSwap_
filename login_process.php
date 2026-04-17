<?php
session_start();
require_once __DIR__ . '/db.php';

function redirect_to_login(string $message): void {
    header('Location: login.php?error=' . urlencode($message));
    exit();
}

function resolve_redirect(string $redirect): string {
    $redirect = trim($redirect);

    if ($redirect === '' || preg_match('#^(?:https?:)?//#i', $redirect)) {
        return 'home.php';
    }

    if ($redirect[0] === '/') {
        $redirect = ltrim($redirect, '/');
    }

    return preg_match('/^[a-zA-Z0-9_\/.-]+\.php(?:\?.*)?$/', $redirect) ? $redirect : 'home.php';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$redirect = resolve_redirect($_POST['redirect'] ?? 'home.php');

if ($email === '' || $password === '') {
    redirect_to_login('Please enter both email and password.');
}

$stmt = mysqli_prepare($conn, 'SELECT id, name, email, password, is_admin FROM users WHERE email = ? LIMIT 1');

if (!$stmt) {
    redirect_to_login('Login is temporarily unavailable. Please try again.');
}

mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = $result ? mysqli_fetch_assoc($result) : null;
mysqli_stmt_close($stmt);

if (!$user) {
    redirect_to_login('No account found with that email.');
}

if (!password_verify($password, $user['password'])) {
    redirect_to_login('Incorrect password. Please try again.');
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];

if (!empty($user['is_admin'])) {
    $_SESSION['is_admin'] = true;
} else {
    unset($_SESSION['is_admin']);
}

header('Location: ' . $redirect);
exit();
