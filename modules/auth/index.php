<?php
// logout/index.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/system-log.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION["{$prefix}userId"])) {
    createSystemLog($stationId, $userId, 'Logged out', $userId, clientIp());
    delete('remember_tokens', '`employee_id` = ?', [$userId]);
    session_destroy();
    setcookie("{$prefix}remember_token", '', [
        'expires' => time() - 3600,
        'path' => '/',
        'domain' => parse_url(uri(), PHP_URL_HOST),
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    setcookie("{$prefix}login", '', [
        'expires' => time() - getSeconds(8),
        'path' => '/',
        'domain' => parse_url(uri(), PHP_URL_HOST),
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    redirect("{$baseUri}/login");
}