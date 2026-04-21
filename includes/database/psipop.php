<?php
// position_items
// step_increments
// loyalty_awards
function psipop($id)
{
    return find("SELECT * FROM `position_items` WHERE `employee_id` = ? LIMIT 1", [$id]);
}

function createPsipop($item_number, $employment_status, $original_appointment_date, $latest_promotion_date, $eligibility, $employee_id)
{
    $data = [
        'item_number' => $item_number,
        'employment_status' => $employment_status,
        'original_appointment_date' => $original_appointment_date,
        'latest_promotion_date' => $latest_promotion_date,
        'eligibility' => $eligibility,
        'employee_id' => $employee_id
    ];

    return insert('position_items', $data);
}

function updatePsipop($item_number, $employment_status, $original_appointment_date, $latest_promotion_date, $eligibility, $employee_id)
{
    $data = [
        'item_number' => $item_number,
        'employment_status' => $employment_status,
        'original_appointment_date' => $original_appointment_date,
        'latest_promotion_date' => $latest_promotion_date,
        'eligibility' => $eligibility
    ];

    return update('position_items', $data, '`employee_id` = ?', [$employee_id]);
}

function deletePsipop($employee_id)
{
    return delete('position_items', '`employee_id` = ?', [$employee_id]);
}

function createStepIncrement($last_step_date, $step, $position_id, $employee_id)
{
    $data = [
        'last_step_date' => $last_step_date,
        'step' => $step,
        'position_id' => $position_id,
        'employee_id' => $employee_id
    ];

    return insert('step_increments', $data);
}

function updateStepIncrement($last_step_date, $step, $salary_grade, $employee_id)
{
    $data = [
        'last_step_date' => $last_step_date,
        'step' => $step,
        'salary_grade' => $salary_grade
    ];

    return update('step_increments', $data, '`employee_id` = ?', [$employee_id]);
}

function deleteStepIncrement($id)
{
    return delete('step_increments', '`employee_id` = ?', [$id]);
}

function createLoyaltyAward($date_last_awarded, $id)
{
    $data = [
        'employee_id' => $id,
        'date_last_awarded' => $date_last_awarded
    ];

    return insert('loyalty_awards', $data);
}

function updateLoyaltyAward($date_last_awarded, $id)
{
    $data = [
        'date_last_awarded' => $date_last_awarded
    ];
    return update('loyalty_awards', $data, '`employee_id` = ?', [$id]);
}

function deleteLoyaltyAward($id)
{
    return delete('loyalty_awards', '`employee_id` = ?', [$id]);
}

function getEmployeeStepIncrement($employee_id)
{
    return find("SELECT * FROM `step_increments` WHERE `employee_id` = ? LIMIT 1", [$employee_id]);
}

function getEmployeeLoyaltyAward($employee_id)
{
    return find("SELECT employee_id, date_last_awarded FROM `loyalty_awards` WHERE `employee_id` = ? LIMIT 1", [$employee_id]);
}

function loyaltyAward($employee_id)
{
    $sql = "SELECT * FROM (
                SELECT pi.`employee_id`, 
                    TIMESTAMPDIFF(YEAR, pi.`original_appointment_date`, NOW()) AS years_active, 
                    TIMESTAMPDIFF(YEAR, la.`date_last_awarded`, NOW()) AS last_awarded 
                FROM `position_items` AS pi 
                INNER JOIN `loyalty_awards` AS la ON pi.`employee_id` = la.`employee_id`
            ) AS service_years 
            WHERE `years_active` >= 10 AND `last_awarded` >= 5 AND `employee_id` = ?";
    return find($sql, [$employee_id]);
}

function stepIncrement($employee_id)
{
    $sql = "SELECT * FROM (
                SELECT `employee_id`, `last_step_date`, `step`, TIMESTAMPDIFF(YEAR, last_step_date, NOW()) AS `years_active` FROM `step_increments`
            ) AS `service_years` 
            WHERE `years_active` >= 3 AND `step` < 8 AND `employee_id` = ?";
    return find($sql, [$employee_id]);
}