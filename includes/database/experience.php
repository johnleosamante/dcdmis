<?php
// service_records

function experiences($person_id)
{
    $sql = "SELECT * FROM `service_records` WHERE `person_id` = ? ORDER BY `from_date` DESC, `to_date` DESC";
    $results = query($sql, [$person_id]);
    return is_array($results) ? $results : [];
}

function experience($person_id, $service_record_id)
{
    $sql = "SELECT * FROM `service_records` WHERE `person_id` = ? AND `id` = ? LIMIT 1";
    return find($sql, [$person_id, $service_record_id]);
}

function createExperience($from_date, $to_date, $is_present, $designation, $appointment_status, $is_government_service, $salary_grade_step_increment, $monthly_salary, $agency_company, $leave_wo_pay, $for_separation, $separation_date, $separation_cause, $person_id)
{
    $data = [
        'from_date' => $from_date,
        'to_date' => $to_date,
        'is_present' => $is_present,
        'designation' => $designation,
        'appointment_status' => $appointment_status,
        'is_government_service' => $is_government_service,
        'salary_grade_step_increment' => $salary_grade_step_increment,
        'monthly_salary' => $monthly_salary,
        'agency_company' => $agency_company,
        'leave_wo_pay' => $leave_wo_pay,
        'for_separation' => $for_separation,
        'separation_date' => $separation_date,
        'separation_cause' => $separation_cause,
        'person_id' => $person_id,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return insert('service_records', $data);
}

function updateExperience($from_date, $to_date, $is_present, $designation, $appointment_status, $is_government_service, $salary_grade_step_increment, $monthly_salary, $agency_company, $leave_wo_pay, $for_separation, $separation_date, $separation_cause, $person_id, $service_record_id)
{
    $data = [
        'from_date' => $from_date,
        'to_date' => $to_date,
        'is_present' => $is_present,
        'designation' => $designation,
        'appointment_status' => $appointment_status,
        'is_government_service' => $is_government_service,
        'salary_grade_step_increment' => $salary_grade_step_increment,
        'monthly_salary' => $monthly_salary,
        'agency_company' => $agency_company,
        'leave_wo_pay' => $leave_wo_pay,
        'for_separation' => $for_separation,
        'separation_date' => $separation_date,
        'separation_cause' => $separation_cause,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return update('service_records', $data, '`person_id` = ? AND `id` = ?', [$person_id, $service_record_id]);
}

function deleteExperience($person_id, $service_record_id)
{
    return delete('service_records', '`person_id` = ? AND `id` = ?', [$person_id, $service_record_id]);
}

function deleteExperiences($person_id)
{
    return delete('service_records', '`person_id` = ?', [$person_id]);
}

function governmentService($id)
{
    $sql = "SELECT * FROM `service_records` WHERE `person_id` = ? AND `is_government_service` = '1' ORDER BY `from_date` DESC";
    return query($sql, [$id]);
}