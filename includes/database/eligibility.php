<?php
// eligibilities
function eligibilities($person_id)
{
    $sql = "SELECT * FROM `eligibilities`  WHERE `person_id` = ? ORDER BY `examination_date` ASC";
    $results = query($sql, [$person_id]);
    return is_array($results) ? $results : [];
}

function eligibility($person_id, $eligibility_id)
{
    $sql = "SELECT * FROM `eligibilities` WHERE `person_id` = ? AND `id` = ? LIMIT 1";
    return find($sql, [$person_id, $eligibility_id]);
}

function createEligibility($title, $rating, $examination_date, $examination_venue, $license_number, $has_expiration, $expiration_date, $person_id)
{
    $data = [
        'title' => $title,
        'rating' => $rating,
        'examination_date' => $examination_date,
        'examination_venue' => $examination_venue,
        'license_number' => $license_number,
        'has_expiration' => $has_expiration,
        'expiration_date' => $expiration_date,
        'person_id' => $person_id
    ];
    return insert('eligibilities', $data);
}

function updateEligibility($title, $rating, $examination_date, $examination_venue, $license_number, $has_expiration, $expiration_date, $person_id, $eligibility_id)
{
    $data = [
        'title' => $title,
        'rating' => $rating,
        'examination_date' => $examination_date,
        'examination_venue' => $examination_venue,
        'license_numnber' => $license_number,
        'has_expiration' => $has_expiration,
        'expiration_date' => $expiration_date
    ];
    return update('eligibilities', $data, "`person_id` = ? AND `id` = ?", [$person_id, $eligibility_id]);
}

function deleteEligibility($person_id, $eligibility_id)
{
    return delete('eligibilities', "`person_id` = ? AND `id` = ?", [$person_id, $eligibility_id]);
}

function deleteEligibilities($person_id)
{
    return delete('eligibilities', "`person_id` = ?", [$person_id]);
}