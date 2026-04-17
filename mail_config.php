<?php
$defaultConfig = [
    'host' => 'smtp.gmail.com',
    'port' => 465,
    'secure' => 'ssl',
    'username' => 'vyomsejpal6@gmail.com',
    'password' => 'kscwhnkulqwwgwef',
    'from_email' => 'vyomsejpal6@gmail.com',
    'from_name' => 'TechSwap',
];

$configPath = __DIR__ . '/mail_config.local.php';
if (file_exists($configPath)) {
    $customConfig = require $configPath;
    if (is_array($customConfig)) {
        return array_merge($defaultConfig, $customConfig);
    }
}

return $defaultConfig;
