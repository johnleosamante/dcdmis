<?php
// transfer_requests

function createTransferRequest($employee_id, $current_station_id, $target_station_id, $reason, $attachment_path, $specialization = null)
{
    $data = [
        'employee_id' => $employee_id,
        'current_station_id' => $current_station_id,
        'target_station_id' => $target_station_id,
        'reason' => $reason,
        'attachment_path' => $attachment_path,
        'specialization' => $specialization,
        'status' => 'Pending'
    ];
    return insert('transfer_requests', $data);
}

function updateTransferRequestStatus($id, $status, $remarks)
{
    $data = [
        'status' => $status,
        'remarks' => $remarks
    ];
    return update('transfer_requests', $data, '`id` = ?', [$id]);
}

function getEmployeeTransferRequests($employee_id)
{
    $results = query(
        "SELECT * FROM `transfer_requests` WHERE `employee_id` = ? ORDER BY `created_at` DESC",
        [$employee_id]
    );
    return is_array($results) ? $results : [];
}

function getTransferRequest($id)
{
    return find("SELECT * FROM `transfer_requests` WHERE `id` = ? LIMIT 1", [$id]);
}

function getAllTransferRequests()
{
    $results = query("SELECT * FROM `transfer_requests` ORDER BY FIELD(`status`, 'Pending', 'Approved', 'Disapproved'), `created_at` DESC");
    return is_array($results) ? $results : [];
}

function countPendingTransferRequests()
{
    $result = find("SELECT COUNT(*) AS `count` FROM `transfer_requests` WHERE `status` = 'Pending'");
    return (int) ($result['count'] ?? 0);
}

function deleteTransferRequest($id, $employee_id)
{
    return delete('transfer_requests', '`id` = ? AND `employee_id` = ?', [$id, $employee_id]);
}