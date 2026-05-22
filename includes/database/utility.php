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

function userName($employee_id, $uppercase = false, $fname_first = true, $middle_initial = true)
{
    $user = employee($employee_id);
    if ($user) {
        $formattedName = toName(
            $user['last_name'],
            $user['first_name'],
            $user['middle_name'],
            $user['name_extension'],
            $fname_first,
            $middle_initial
        );
        if ($fname_first) {
            $prefix = toString($user['name_prefix'], '', ' ');
            $suffix = toString($user['name_suffix'], ', ');
            $formattedName = "{$prefix}{$formattedName}{$suffix}";
        }
        if ($uppercase) {
            return strtoupper($formattedName);
        }
        return $formattedName;
    }
    return $employee_id;
}

function pdsProgress($employee_id)
{
    $progress = 15;
    $educationCount = count(educationalBackgrounds($employee_id) ?: []);
    if ($educationCount === 1) {
        $progress += 5;
    } elseif ($educationCount === 2) {
        $progress += 15;
    } elseif ($educationCount >= 3) {
        $progress += 25;
    }
    if (!empty(eligibilities($employee_id))) {
        $progress += 25;
    }
    if (!empty(experiences($employee_id))) {
        $progress += 20;
    }
    if (!empty(attendedTrainings($employee_id))) {
        $progress += 15;
    }
    return min($progress, 100);
}