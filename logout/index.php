<?php
# logout/index.php
include_once('../_includes_/function.php');
include_once('../_includes_/database/database.php');
include_once('../_includes_/database/system-logs.php');

if (isset($_SESSION['uid'])) {
  SystemLogout($_SESSION['school_id'], $_SESSION['uid'], GetDateTime(), GetClientIP());
}

session_destroy();
header('location:' . GetSiteURL() . '/login');
?>