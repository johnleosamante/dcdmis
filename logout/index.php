<?php
# logout/index.php
include_once('../_includes_/function.php');
include_once('../_includes_/database/database.php');
include_once('../_includes_/database/system-logs.php');

if (isset($_SESSION[GetSiteAlias() . '_uid'])) {
  SystemLogout($_SESSION[GetSiteAlias() . '_school_id'], $_SESSION[GetSiteAlias() . '_uid'], GetDateTime(), GetClientIP());
}

session_destroy();
header('location:' . GetSiteURL() . '/login');
?>