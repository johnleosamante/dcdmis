<?php
// voluntary_works
function voluntaryWorks($employee_id)
{
    $sql = "SELECT * FROM `voluntary_works` WHERE `employee_id` = ? ORDER BY `is_present` DESC, `from_date` DESC, `to_date` DESC";
    return query($sql, [$employee_id]);
}

function voluntaryWork($employee_id, $voluntary_work_id)
{
    $sql = "SELECT * FROM `voluntary_works` WHERE `employee_id` = ? AND `id` = ? LIMIT 1";
    return find($sql, [$employee_id, $voluntary_work_id]);
}

function createVoluntaryWork($organization, $from_date, $to_date, $is_present, $number_of_hours, $position_nature_of_work, $employee_id)
{
    $data = [
        'organization' => $organization,
        'from_date' => $from_date,
        'to_date' => $to_date,
        'is_present' => $is_present,
        'number_of_hours' => $number_of_hours,
        'position_nature_of_work' => $position_nature_of_work,
        'employee_id' => $employee_id
    ];
    return insert('voluntary_works', $data);
}

function updateVoluntaryWork($organization, $from_date, $to_date, $is_present, $number_of_hours, $position_nature_of_work, $employee_id, $voluntary_work_id)
{
    $data = [
        'organization' => $organization,
        'from_date' => $from_date,
        'to_date' => $is_present ? null : $to_date,
        'is_present' => $is_present ? 1 : 0,
        'number_of_hours' => $number_of_hours,
        'position_nature_of_work' => $position_nature_of_work
    ];

    return update('voluntary_works', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $voluntary_work_id]);
}

function deleteVoluntaryWork($employee_id, $voluntary_work_id)
{
    return delete('voluntary_works', '`employee_id` = ? AND `id` = ?', [$employee_id, $voluntary_work_id]);
}

function deleteVoluntaryWorks($id)
{
    return delete('voluntary_works', '`employee_id` = ?', [$id]);
}