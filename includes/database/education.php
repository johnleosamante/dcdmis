<?php
// educational_backgrounds
function educationalBackgrounds($person_id)
{
    $sql = "SELECT * FROM `educational_backgrounds` WHERE `person_id` = ? ORDER BY `from_year` ASC, `to_year` ASC";
    $results = query($sql, [$person_id]);
    return is_array($results) ? $results : [];
}

function educationalBackground($person_id, $educationl_background_id)
{
    $sql = "SELECT * FROM `educational_backgrounds` WHERE `person_id` = ? AND `id` = ? LIMIT 1";
    return find($sql, [$person_id, $educationl_background_id]);
}

function createEducation($level, $school, $course, $from_year, $to_year, $is_present, $highest_level, $year_graduated, $honors_received, $person_id)
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
        'person_id' => $person_id
    ];

    return insert('educational_backgrounds', $data);
}

function updateEducation($level, $school, $course, $from_year, $to_year, $is_present, $highest_level, $year_graduated, $honors_received, $person_id, $educational_background_id)
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
    return update('educational_backgrounds', $data, "`person_id` = ? AND `id` = ?", [$person_id, $educational_background_id]);
}

function deleteEducation($person_id, $educational_background_id)
{
    return delete('educational_backgrounds', "`person_id` = ? AND `id` = ?", [$person_id, $educational_background_id]);
}

function deleteEducations($person_id)
{
    return delete('educational_backgrounds', "`person_id` = ?", [$person_id]);
}