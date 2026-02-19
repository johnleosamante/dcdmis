<?php
// voluntary_works
function voluntaryWorks($person_id)
{
    $sql = "SELECT * FROM `voluntary_works` WHERE `id` = ? ORDER BY `is_present` DESC, `from_date` DESC, `to_date` DESC";
    return query($sql, [$person_id]);
}

function voluntaryWork($person_id, $voluntary_work_id)
{
    $sql = "SELECT * FROM `voluntary_works` WHERE `person_id` = ? AND `id` = ? LIMIT 1";
    return find($sql, [$person_id, $voluntary_work_id]);
}

function createVoluntaryWork($organization, $from_date, $to_date, $is_present, $number_of_hours, $position_nature_of_work, $person_id)
{
    $data = [
        'organization' => $organization,
        'from_date' => $from_date,
        'to_date' => $is_present ? null : $to_date,
        'is_present' => $is_present ? 1 : 0,
        'number_of_hours' => $number_of_hours,
        'position_nature_of_work' => $position_nature_of_work,
        'person_id' => $person_id
    ];
    return insert('voluntary_works', $data);
}

function updateVoluntaryWork($organization, $from_date, $to_date, $is_present, $number_of_hours, $position_nature_of_work, $person_id, $voluntary_work_id)
{
    $data = [
        'organization' => $organization,
        'from_date' => $from_date,
        'to_date' => $is_present ? null : $to_date,
        'is_present' => $is_present ? 1 : 0,
        'number_of_hours' => $number_of_hours,
        'position_nature_of_work' => $position_nature_of_work
    ];

    return update('voluntary_works', $data, '`person_id` = ? AND `id` = ?', [$person_id, $voluntary_work_id]);
}

function deleteVoluntaryWork($person_id, $voluntary_work_id)
{
    return delete('voluntary_works', '`person_id` = ? AND `id` = ?', [$person_id, $voluntary_work_id]);
}

function deleteVoluntaryWorks($id)
{
    return delete('voluntary_works', '`person_id` = ?', [$id]);
}