<?php
// payslips
function payslips($employee_id)
{
    $results = query("SELECT * FROM `payslips` WHERE `employee_id` = ? ORDER BY `updated_at` DESC", [$employee_id]);
    return is_array($results) ? $results : [];
}

function payslip($employee_id, $payslip_id)
{
    return find("SELECT * FROM `payslips` WHERE `employee_id` = ? AND `id` = ? LIMIT 1", [$employee_id, $payslip_id]);
}

function createPayslip($description, $file_name, $file_extension, $employee_id)
{
    $data = [
        'employee_id' => $employee_id,
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension
    ];
    return insert('payslips', $data);
}

function updatePayslip($description, $file_name, $file_extension, $employee_id, $payslip_id)
{
    $data = [
        'description' => $description,
        'file_name' => $file_name,
        'file_extension' => $file_extension
    ];
    return update('payslips', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $payslip_id]);
}

function deletePayslip($employee_id, $payslip_id)
{
    return delete('payslips', '`employee_id` = ? AND `id` = ?', [$employee_id, $payslip_id]);
}

function deletePayslips($employee_id)
{
    return delete('payslips', '`employee_id` = ?', [$employee_id]);
}