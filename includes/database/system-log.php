<?php
// system_logs
function userLog($employee_id)
{
    $sql = "SELECT * FROM `system_logs` WHERE `employee_id` = ? ORDER BY `created_at` DESC LIMIT 1000";
    return query($sql, [$employee_id]);
}

function systemLogs($from_date, $to_date)
{
    $sql = "SELECT * FROM `system_logs` WHERE `action` NOT LIKE '%document%' 
            AND `created_at` BETWEEN ? AND DATE_ADD(?, INTERVAL 1 DAY) ORDER BY `created_at` DESC LIMIT 1000";
    return query($sql, [$from_date, $to_date]);
}

function createSystemLog($station_id, $employee_id, $action, $target_id, $ip)
{
    $data = [
        'station_id' => $station_id,
        'employee_id' => $employee_id,
        'action' => $action,
        'target_id' => $target_id,
        'ip' => $ip
    ];
    return insert('system_logs', $data);
}

function employeeEditHistory($target_id)
{
    $sql = "SELECT * FROM `system_logs` WHERE `target_id` = ? AND `action` NOT LIKE '%logged%' ORDER BY `created_at` DESC LIMIT 1000";
    return query($sql, [$target_id]);
}

function checkRateLimit(string $ip_address, int $max_attempts = 5, int $lockout_window_seconds = 300): bool
{
    $sql = "SELECT `attempts`, `last_attempt` FROM `rate_limits` WHERE `ip_address` = ?";
    $result = find($sql, [$ip_address]);
    if (!$result) {
        return true;
    }
    $seconds_since_last_attempt = time() - strtotime($result['last_attempt']);
    if ($seconds_since_last_attempt > $lockout_window_seconds) {
        return true;
    }
    return (int) $result['attempts'] < $max_attempts;
}

function getRateLimitRemainingTime(string $ip_address, int $lockout_window_seconds = 300): int
{
    $sql = "SELECT `last_attempt` FROM `rate_limits` WHERE `ip_address` = ?";
    $result = find($sql, [$ip_address]);
    if (!$result || !isset($result['last_attempt'])) {
        return 0;
    }
    $seconds_since_last_attempt = time() - strtotime($result['last_attempt']);
    $remainingTime = $lockout_window_seconds - $seconds_since_last_attempt;

    return $remainingTime > 0 ? $remainingTime : 0;
}

function clearRateLimit(string $ip_address): bool
{
    return delete('rate_limits', "`ip_address` = ?", [$ip_address]);
}

function recordFailedAttempt(string $ip_address, int $lockout_window_seconds = 300): bool
{
    $sql = "INSERT INTO `rate_limits` (`ip_address`, `attempts`, `last_attempt`) 
            VALUES (?, 1, NOW()) 
            ON DUPLICATE KEY UPDATE 
                `attempts` = IF(TIMESTAMPDIFF(SECOND, `last_attempt`, NOW()) > ?, 1, `attempts` + 1), 
                `last_attempt` = NOW()";
    return query($sql, [$ip_address, $lockout_window_seconds]);
}