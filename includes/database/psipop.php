<?php
// position_items
// step_increments
// loyalty_awards
function psipop($id)
{
    $sql = "SELECT 
                `id` AS `no`, 
                `item_number` AS `item`, 
                `job_status` AS `status`, 
                `original_appointment_date`, 
                `date_promoted`, 
                `eligibility` 
            FROM `position_items` 
            WHERE `person_id` = ? LIMIT 1";

    return find($sql, [$id]);
}

function createPsipop($itemNo, $status, $originalAppointment, $datePromoted, $eligibility, $id)
{
    $data = [
        'item_number' => $itemNo,
        'job_status' => $status,
        'original_appointment_date' => $originalAppointment,
        'date_promoted' => $datePromoted,
        'eligibility' => $eligibility,
        'person_id' => $id
    ];

    return insert('position_items', $data);
}

function updatePsipop($itemNo, $status, $originalAppointment, $datePromoted, $eligibility, $id)
{
    $data = [
        'item_number' => $itemNo,
        'job_status' => $status,
        'original_appointment_date' => $originalAppointment,
        'date_promoted' => $datePromoted,
        'eligibility' => $eligibility
    ];

    return update('position_items', $data, '`person_id` = ?', [$id]);
}

function deletePsipop($id)
{
    return delete('position_items', '`person_id` = ?', [$id]);
}

function createStepIncrement($dateLastStep, $stepNo, $sg, $id)
{
    $data = [
        'last_step_date' => $dateLastStep,
        'step' => $stepNo,
        'salary_grade' => $sg,
        'person_id' => $id
    ];

    return insert('step_increments', $data);
}

function updateStepIncrement($dateLastStep, $stepNo, $sg, $id)
{
    $data = [
        'last_step_date' => $dateLastStep,
        'step' => $stepNo,
        'salary_grade' => $sg
    ];

    return update('step_increments', $data, '`person_id` = ?', [$id]);
}

function deleteStepIncrement($id)
{
    return delete('step_increments', '`person_id` = ?', [$id]);
}

function createLoyaltyAward($dateLastAwarded, $id)
{
    $data = [
        'person_id' => $id,
        'date_last_awarded' => $dateLastAwarded
    ];

    return insert('loyalty_awards', $data);
}

function updateLoyaltyAward($dateLastAwarded, $id)
{
    $data = [
        'date_last_awarded' => $dateLastAwarded
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