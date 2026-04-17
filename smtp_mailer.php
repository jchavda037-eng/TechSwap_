<?php

function smtp_read_response($socket): string {
    $response = '';
    while (($line = fgets($socket, 515)) !== false) {
        $response .= $line;
        if (preg_match('/^\d{3}\s/', $line)) {
            break;
        }
    }
    return $response;
}

function smtp_expect($socket, array $codes): string {
    $response = smtp_read_response($socket);
    $status = (int) substr($response, 0, 3);
    if (!in_array($status, $codes, true)) {
        throw new RuntimeException(trim($response));
    }
    return $response;
}

function smtp_command($socket, string $command, array $codes): string {
    fwrite($socket, $command . "\r\n");
    return smtp_expect($socket, $codes);
}

function send_smtp_mail(string $toEmail, string $subject, string $message): bool {
    $config = require __DIR__ . '/mail_config.php';
    $transport = ($config['secure'] === 'ssl' ? 'ssl://' : '') . $config['host'] . ':' . $config['port'];

    $socket = stream_socket_client($transport, $errno, $errstr, 30);
    if (!$socket) {
        throw new RuntimeException("SMTP connection failed: $errstr ($errno)");
    }

    stream_set_timeout($socket, 30);

    try {
        smtp_expect($socket, [220]);
        smtp_command($socket, 'EHLO localhost', [250]);
        smtp_command($socket, 'AUTH LOGIN', [334]);
        smtp_command($socket, base64_encode($config['username']), [334]);
        smtp_command($socket, base64_encode(str_replace(' ', '', $config['password'])), [235]);
        smtp_command($socket, 'MAIL FROM:<' . $config['from_email'] . '>', [250]);
        smtp_command($socket, 'RCPT TO:<' . $toEmail . '>', [250, 251]);
        smtp_command($socket, 'DATA', [354]);

        $headers = [
            'From: ' . $config['from_name'] . ' <' . $config['from_email'] . '>',
            'To: <' . $toEmail . '>',
            'Subject: ' . $subject,
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
        ];

        $body = implode("\r\n", $headers) . "\r\n\r\n" . str_replace("\n", "\r\n", $message) . "\r\n.";
        fwrite($socket, $body . "\r\n");
        smtp_expect($socket, [250]);
        smtp_command($socket, 'QUIT', [221]);
        fclose($socket);
        return true;
    } catch (Throwable $e) {
        fclose($socket);
        throw $e;
    }
}
