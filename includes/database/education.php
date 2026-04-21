<?php
// educational_backgrounds
function educationalBackgrounds($employee_id)
{
    $sql = "SELECT * FROM `educational_backgrounds` WHERE `employee_id` = ? ORDER BY `from_year` ASC, `to_year` ASC";
    $results = query($sql, [$employee_id]);
    return is_array($results) ? $results : [];
}

function educationalBackground($employee_id, $educationl_background_id)
{
    $sql = "SELECT * FROM `educational_backgrounds` WHERE `employee_id` = ? AND `id` = ? LIMIT 1";
    return find($sql, [$employee_id, $educationl_background_id]);
}

function createEducation($level, $school, $course, $from_year, $to_year, $is_present, $highest_level, $year_graduated, $honors_received, $employee_id)
{
    $data = [
        'level' => $level,
        'school' => $school,
        'course' => $course,
        'from_year' => $from_year,
        'to_year' => $to_year,
        'is_present' => $is_present,
        'highest_level' => $highest_level,
        'year_graduated' => $year_graduated,
        'honors_received' => $honors_received,
        'employee_id' => $employee_id
    ];

    return insert('educational_backgrounds', $data);
}

function updateEducation($level, $school, $course, $from_year, $to_year, $is_present, $highest_level, $year_graduated, $honors_received, $employee_id, $educational_background_id)
{
    $data = [
        'level' => $level,
        'school' => $school,
        'course' => $course,
        'from_year' => $from_year,
        'to_year' => $to_year,
        'is_present' => $is_present,
        'highest_level' => $highest_level,
        'year_graduated' => $year_graduated,
        'honors_received' => $honors_received
    ];
    return update('educational_backgrounds', $data, "`employee_id` = ? AND `id` = ?", [$employee_id, $educational_background_id]);
}

function deleteEducation($employee_id, $educational_background_id)
{
    return delete('educational_backgrounds', "`employee_id` = ? AND `id` = ?", [$employee_id, $educational_background_id]);
}

function deleteEducations($employee_id)
{
    return delete('educational_backgrounds', "`employee_id` = ?", [$employee_id]);
}