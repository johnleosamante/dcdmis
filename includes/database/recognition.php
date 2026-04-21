<?php
// recognitions
function recognitions($employee_id)
{
    $results = query("SELECT * FROM `recognitions` WHERE `employee_id` = ? ORDER BY `title` ASC", [$employee_id]);
    return is_array($results) ? $results : [];
}

function recognition($employee_id, $recognition_id)
{
    return find("SELECT * FROM `recognitions` WHERE `employee_id` = ? AND `id` = ? LIMIT 1", [$employee_id, $recognition_id]);
}

function createRecognition($title, $employee_id)
{
    $data = [
        'title' => $title,
        'employee_id' => $employee_id
    ];

    return insert('recognitions', $data);
}

function updateRecognition($title, $employee_id, $recognition_id)
{
    $data = [
        'title' => $title
    ];
    return update('recognitions', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $recognition_id]);
}

function deleteRecognition($employee_id, $recognition_id)
{
    return delete('recognitions', '`employee_id` = ? AND `id` = ?', [$employee_id, $recognition_id]);
}

function deleteRecognitions($employee_id)
{
    return delete('recognitions', '`employee_id` = ?', [$employee_id]);
}