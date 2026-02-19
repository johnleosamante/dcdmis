<?php
// recognitions
function recognitions($person_id)
{
    $results = query("SELECT * FROM `recognitions` WHERE `person_id` = ? ORDER BY `title` ASC", [$person_id]);
    return is_array($results) ? $results : [];
}

function recognition($person_id, $recognition_id)
{
    return find("SELECT * FROM `recognitions` WHERE `person_id` = ? AND `id` = ? LIMIT 1", [$person_id, $recognition_id]);
}

function createRecognition($title, $person_id)
{
    $data = [
        'title' => $title,
        'person_id' => $person_id
    ];

    return insert('recognitions', $data);
}

function updateRecognition($title, $person_id, $recognition_id)
{
    return update('recognitions', ['title' => $title], '`person_id` = ? AND `recognition_id` = ?', [$person_id, $recognition_id]);
}

function deleteRecognition($person_id, $recognition_id)
{
    return delete('recognitions', '`person_id` = ? AND `id` = ?', [$person_id, $recognition_id]);
}

function deleteRecognitions($person_id)
{
    return delete('recognitions', '`person_id` = ?', [$person_id]);
}