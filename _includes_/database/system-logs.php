<?php
# _includes_/database/system-logs.php

function SystemLogout($stationID, $userID, $dateTime, $clientIP) {
  DBNonQuery("INSERT INTO tbl_system_logs (SchoolID, Emp_ID, Time_Log, `Status`, IPAddress) VALUES ('$stationID', '$userID', '$dateTime', 'Logout', '$clientIP');");
}

function SystemLogin($stationID, $userID, $dateTime, $clientIP) {
  DBNonQuery("INSERT INTO tbl_system_logs (SchoolID, Emp_ID, Time_Log, `Status`, IPAddress) VALUES ('$stationID', '$userID', '$dateTime', 'Login', '$clientIP');");
}
?>