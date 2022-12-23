<?php
# _includes_/database/system-logs.php

function SystemLogout($station, $userid, $datetime, $clientip) {
  DBNonQuery("INSERT INTO tbl_system_logs (SchoolID, Emp_ID, Time_Log, `Status`, IPAddress) VALUES ('$station', '$userid', '$datetime', 'Logout', '$clientip');");
}
?>