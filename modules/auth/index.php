<?php
// logout/index.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/system-log.php');

if (isset($_SESSION["{$prefix}userId"])) {
    createSystemLog($stationId, $userId, 'Logged out', $userId, clientIp());
    session_destroy();
    setcookie("{$prefix}login", '', time() - getSeconds(8), '/', uri(), false, true);
    redirect("{$baseUri}/login");
}