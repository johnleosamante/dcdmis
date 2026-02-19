<?php
// position_items
// step_increments
// loyalty_awards
function psipop($id)
{
    return find("SELECT * FROM `position_items` WHERE `person_id` = ? LIMIT 1", [$id]);
}

function createPsipop($item_number, $employment_status, $original_appointment_date, $latest_promotion_date, $eligibility, $person_id)
{
    $data = [
        'item_number' => $item_number,
        'employment_status' => $employment_status,
        'original_appointment_date' => $original_appointment_date,
        'latest_promotion_date' => $latest_promotion_date,
        'eligibility' => $eligibility,
        'person_id' => $person_id
    ];

    return insert('position_items', $data);
}

function updatePsipop($item_number, $employment_status, $original_appointment_date, $latest_promotion_date, $eligibility, $person_id)
{
    $data = [
        'item_number' => $item_number,
        'employment_status' => $employment_status,
        'original_appointment_date' => $original_appointment_date,
        'latest_promotion_date' => $latest_promotion_date,
        'eligibility' => $eligibility,
    ];

    return update('position_items', $data, '`person_id` = ?', [$person_id]);
}

function deletePsipop($person_id)
{
    return delete('position_items', '`person_id` = ?', [$person_id]);
}

function createStepIncrement($last_step_date, $step, $salary_grade, $person_id)
{
    $data = [
        'last_step_date' => $last_step_date,
        'step' => $step,
        'salary_grade' => $salary_grade,
        'person_id' => $person_id
    ];

    return insert('step_increments', $data);
}

function updateStepIncrement($last_step_date, $step, $salary_grade, $person_id)
{
    $data = [
        'last_step_date' => $last_step_date,
        'step' => $step,
        'salary_grade' => $salary_grade
    ];

    return update('step_increments', $data, '`person_id` = ?', [$person_id]);
}

function deleteStepIncrement($id)
{
    return delete('step_increments', '`person_id` = ?', [$id]);
}

function createLoyaltyAward($date_last_awarded, $id)
{
    $data = [
        'person_id' => $id,
        'date_last_awarded' => $date_last_awarded
    ];

    return insert('loyalty_awards', $data);
}

function updateLoyaltyAward($date_last_awarded, $id)
{
    $data = [
        'date_last_awarded' => $date_last_awarded
    ];
    return update('loyalty_awards', $data, '`person_id` = ?', [$id]);
}

function deleteLoyaltyAward($id)
{
    return delete('loyalty_awards', '`person_id` = ?', [$id]);
}

function getEmployeeStepIncrement($person_id)
{
    return find("SELECT * FROM `step_increments` WHERE `person_id` = ? LIMIT 1", [$person_id]);
}

function getEmployeeLoyaltyAward($person_id)
{
    return find("SELECT person_id, date_last_awarded FROM `loyalty_awards` WHERE `person_id` = ? LIMIT 1", [$person_id]);
}

// TODO
function loyaltyAward($person_id)
{
    $sql = "SELECT * FROM (
                SELECT pi.`person_id`, 
                    TIMESTAMPDIFF(YEAR, pi.`original_appointment_date`, NOW()) AS years_active, 
                    TIMESTAMPDIFF(YEAR, la.`date_last_awarded`, NOW()) AS last_awarded 
                FROM `position_items` AS pi 
                INNER JOIN `loyalty_awards` AS la ON pi.`person_id` = la.`person_id`
            ) AS service_years 
            WHERE `years_active` >= 10 AND `last_awarded` >= 5 AND `person_id` = ?";
    return find($sql, [$person_id]);
}

// TODO
function stepIncrement($person_id)
{
    $sql = "SELECT * FROM (
                SELECT `person_id`, `last_step_date`, `step`, TIMESTAMPDIFF(YEAR, last_step_date, NOW()) AS `years_active` FROM `step_increments`
            ) AS `service_years` 
            WHERE `years_active` >= 3 AND `step` < 8 AND `person_id` = ?";
    return find($sql, [$person_id]);
}