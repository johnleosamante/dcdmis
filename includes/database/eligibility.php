<?php
// eligibilities
function eligibilities($employee_id)
{
    $sql = "SELECT * FROM `eligibilities`  WHERE `employee_id` = ? ORDER BY `examination_date` ASC";
    $results = query($sql, [$employee_id]);
    return is_array($results) ? $results : [];
}

function eligibility($employee_id, $eligibility_id)
{
    $sql = "SELECT * FROM `eligibilities` WHERE `employee_id` = ? AND `id` = ? LIMIT 1";
    return find($sql, [$employee_id, $eligibility_id]);
}

function createEligibility($title, $rating, $examination_date, $examination_venue, $license_number, $has_expiration, $expiration_date, $employee_id)
{
    $data = [
        'title' => $title,
        'rating' => $rating,
        'examination_date' => $examination_date,
        'examination_venue' => $examination_venue,
        'license_number' => $license_number,
        'has_expiration' => $has_expiration,
        'expiration_date' => $expiration_date,
        'employee_id' => $employee_id
    ];
    return insert('eligibilities', $data);
}

function updateEligibility($title, $rating, $examination_date, $examination_venue, $license_number, $has_expiration, $expiration_date, $employee_id, $eligibility_id)
{
    $data = [
        'title' => $title,
        'rating' => $rating,
        'examination_date' => $examination_date,
        'examination_venue' => $examination_venue,
        'license_number' => $license_number,
        'has_expiration' => $has_expiration,
        'expiration_date' => $expiration_date
    ];
    return update('eligibilities', $data, "`employee_id` = ? AND `id` = ?", [$employee_id, $eligibility_id]);
}

function deleteEligibility($employee_id, $eligibility_id)
{
    return delete('eligibilities', "`employee_id` = ? AND `id` = ?", [$employee_id, $eligibility_id]);
}

function deleteEligibilities($employee_id)
{
    return delete('eligibilities', "`employee_id` = ?", [$employee_id]);
}