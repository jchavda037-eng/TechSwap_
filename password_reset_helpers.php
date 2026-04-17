<?php
require_once __DIR__ . '/db.php';

function ensure_password_reset_table(mysqli $conn): void {
    mysqli_query(
        $conn,
        "CREATE TABLE IF NOT EXISTS password_reset_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            token_hash VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            used_at DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_user_id (user_id),
            INDEX idx_expires_at (expires_at),
            CONSTRAINT fk_password_reset_user
                FOREIGN KEY (user_id) REFERENCES users(id)
                ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
    );
}

function find_user_by_email(mysqli $conn, string $email): ?array {
    $stmt = mysqli_prepare($conn, 'SELECT id, name, email FROM users WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);
    return $user ?: null;
}

function create_password_reset_token(mysqli $conn, int $userId): string {
    mysqli_query($conn, "UPDATE password_reset_tokens SET used_at = NOW() WHERE user_id = $userId AND used_at IS NULL");

    $token = bin2hex(random_bytes(32));
    $tokenHash = password_hash($token, PASSWORD_DEFAULT);
    $expiresAt = date('Y-m-d H:i:s', time() + 3600);

    $stmt = mysqli_prepare(
        $conn,
        'INSERT INTO password_reset_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)'
    );
    mysqli_stmt_bind_param($stmt, 'iss', $userId, $tokenHash, $expiresAt);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $token;
}

function find_valid_reset_token(mysqli $conn, string $token): ?array {
    $result = mysqli_query(
        $conn,
        "SELECT prt.id, prt.user_id, prt.token_hash, prt.expires_at, u.email
         FROM password_reset_tokens prt
         INNER JOIN users u ON u.id = prt.user_id
         WHERE prt.used_at IS NULL
         ORDER BY prt.id DESC"
    );

    while ($row = mysqli_fetch_assoc($result)) {
        if (strtotime($row['expires_at']) < time()) {
            continue;
        }
        if (password_verify($token, $row['token_hash'])) {
            return $row;
        }
    }

    return null;
}

function mark_reset_token_used(mysqli $conn, int $tokenId): void {
    $stmt = mysqli_prepare($conn, 'UPDATE password_reset_tokens SET used_at = NOW() WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $tokenId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
