<?php
// logout/index.php
require_once('../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/system-log.php');

createSystemLog($stationId, $userId, 'Logged out', $userId, clientIp());
session_destroy();
setcookie(alias() . '_login', '', time() - getSeconds(8), '/', uri(), false, true);
if (!$isPublic) { 
  redirect(uri() . '/login');
} else {
  redirect(uri() . '/dts');
}
?>