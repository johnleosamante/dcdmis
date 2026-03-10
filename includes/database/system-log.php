<?php
// system_logs
function userLog($person_id)
{
    $sql = "SELECT * FROM `system_logs` WHERE `person_id` = ? ORDER BY `created_at` DESC";
    return query($sql, [$person_id]);
}

function systemLogs($from_date, $to_date)
{
    $sql = "SELECT * FROM `system_logs` WHERE `action` NOT LIKE '%document%' 
            AND `created_at` BETWEEN ? AND DATE_ADD(?, INTERVAL 1 DAY) ORDER BY `created_at` DESC";
    return query($sql, [$from_date, $to_date]);
}

function createSystemLog($station_id, $person_id, $action, $target_id, $ip)
{
    $data = [
        'station_id' => $station_id,
        'person_id' => $person_id,
        'action' => $action,
        'target_id' => $target_id,
        'ip' => $ip,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return insert('system_logs', $data);
}

function employeeEditHistory($target_id)
{
    $sql = "SELECT * FROM `system_logs` WHERE `target_id` = ? AND `action` NOT LIKE '%logged%' ORDER BY `created_at` DESC";
    return query($sql, [$target_id]);
}