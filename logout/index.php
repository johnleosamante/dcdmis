<?php
# logout/index.php

include_once('../_includes_/function.php');
include_once('../_includes_/database/database.php');

if (isset($_SESSION['uid'])) {
  DBQuery("INSERT INTO tbl_system_logs (SchoolID, Emp_ID, Time_Log, `Status`, IPAddress) VALUES ('" . $_SESSION['school_id'] . "', '" . $_SESSION['uid'] . "', '" . GetDateTime() . "', 'Logout', '$IP');");
}

session_destroy();
header('location:' . GetSiteURL() . '/login');
?>