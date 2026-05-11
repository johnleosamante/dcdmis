<?php
// logout/index.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/system-log.php');

if (isset($_SESSION["{$prefix}userId"])) {
    createSystemLog($stationId, $userId, 'Logged out', $userId, clientIp());
    session_destroy();
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