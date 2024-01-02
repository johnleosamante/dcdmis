<?php
// includes/database/system-log.php
// tbl_employee
// tbl_system_logs
function userLog($id)
{
    return query("SELECT `Time_Log` AS `datetime`, `Status` AS `activity`, `target_id` AS `target`, `IPAddress` AS `ip` FROM tbl_system_logs WHERE Emp_ID='{$id}' ORDER BY `Time_Log` DESC;");
}

function systemLogs()
{
    return query("SELECT `tbl_employee`.`Emp_LName` AS lname, `tbl_employee`.`Emp_FName` AS fname, `tbl_employee`.`Emp_MName` AS mname, `tbl_employee`.`Emp_Extension` AS ext, `tbl_system_logs`.`Time_Log` AS `datetime`, `tbl_system_logs`.`Status` AS `activity`, `tbl_system_logs`.`target_id` AS `target`, `tbl_system_logs`.`IPAddress` AS ip FROM tbl_employee INNER JOIN tbl_system_logs ON tbl_employee.Emp_ID=tbl_system_logs.Emp_ID ORDER BY tbl_system_logs.Time_Log DESC;");
}

function createSystemLog($stationId, $id, $status, $targetId, $ip)
{
    nonQuery("INSERT INTO tbl_system_logs (`SchoolID`, `Emp_ID`, `Time_Log`, `Status`, `target_id`, `IPAddress`) VALUES ('{$stationId}', '{$id}', NOW(), '{$status}', '{$targetId}', '{$ip}');");
}
