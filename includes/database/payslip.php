<?php
// payslips
function payslips($person_id)
{
    $results = query("SELECT * FROM `payslips` WHERE `person_id` = ? ORDER BY `updated_at` DESC", [$person_id]);
    return is_array($results) ? $results : [];
}

function payslip($person_id, $payslip_id)
{
    return find("SELECT * FROM `payslips` WHERE `person_id` = ? AND `id` = ? LIMIT 1", [$person_id, $payslip_id]);
}

function createPayslip($description, $file_name, $file_extension, $person_id)
{
    $data = [
        'person_id' => $person_id,
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return insert('payslips', $data);
}

function updatePayslip($description, $file_name, $file_extension, $person_id, $payslip_id)
{
    $data = [
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return update('payslips', $data, '`person_id` = ? AND `id` = ?', [$person_id, $payslip_id]);
}

function deletePayslip($person_id, $payslip_id)
{
    return delete('payslips', '`person_id` = ? AND `id` = ?', [$person_id, $payslip_id]);
}

function deletePayslips($person_id)
{
    return delete('payslips', '`person_id` = ?', [$person_id]);
}