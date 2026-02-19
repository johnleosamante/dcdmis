<?php
function stationName($station_id)
{
    $station = section($station_id);
    if ($station) {
        return $station['name'];
    }
    $station = schoolByAlias($station_id);
    if ($station) {
        return $station['name'];
    }
    $station = schoolById($station_id);
    if ($station) {
        return $station['name'];
    }
    return $station_id;
}

function userName($person_id, $uppercase = false)
{
    $user = employee($person_id);
    if ($user) {
        $formattedName = toName(
            $user['last_name'],
            $user['first_name'],
            $user['middle_name'],
            $user['name_extension'],
            true
        );
        if ($uppercase) {
            $formattedName = strtoupper($formattedName);
        }
        $prefix = toString($user['name_prefix'], '', ' ');
        $suffix = toString($user['name_suffix'], ', ');
        return "{$prefix}{$formattedName}{$suffix}";
    }
    return $person_id;
}

function pdsProgress($person_id)
{
    $progress = 15;
    $educationCount = count(educationalBackgrounds($person_id) ?: []);
    if ($educationCount === 1) {
        $progress += 5;
    } elseif ($educationCount === 2) {
        $progress += 15;
    } elseif ($educationCount >= 3) {
        $progress += 25;
    }
    if (!empty(eligibilities($person_id))) {
        $progress += 25;
    }
    if (!empty(experiences($person_id))) {
        $progress += 20;
    }
    if (!empty(attendedTrainings($person_id))) {
        $progress += 15;
    }
    return min($progress, 100);
}