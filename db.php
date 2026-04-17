<?php
$defaultConfig = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'order_db',
];

$configPath = __DIR__ . '/db_config.php';
$config = file_exists($configPath) ? require $configPath : $defaultConfig;
$config = array_merge($defaultConfig, is_array($config) ? $config : []);

$conn = mysqli_connect(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database']
);

if (!$conn) {
    die('Connection Failed: ' . mysqli_connect_error());
}
