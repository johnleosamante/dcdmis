<?php
// family_backgrounds
function family($person_id)
{
    return find("SELECT * FROM `family_backgrounds` WHERE `person_id` = ? LIMIT 1", [$person_id]);
}

function createFamily($spouse_last_name, $spouse_first_name, $spouse_name_extension, $spouse_middle_name, $spouse_occupation, $spouse_employer, $spouse_employer_address, $spouse_telephone, $father_last_name, $father_first_name, $father_name_extension, $father_middle_name, $mother_last_name, $mother_first_name, $mother_middle_name, $person_id)
{
    $data = [
        'person_id' => $person_id,
        'spouse_last_name' => $spouse_last_name,
        'spouse_first_name' => $spouse_first_name,
        'spouse_middle_name' => $spouse_middle_name,
        'spouse_name_extension' => $spouse_name_extension,
        'spouse_occupation' => $spouse_occupation,
        'spouse_employer' => $spouse_employer,
        'spouse_employer_address' => $spouse_employer_address,
        'spouse_telephone' => $spouse_telephone,
        'father_last_name' => $father_last_name,
        'father_first_name' => $father_first_name,
        'father_name_extension' => $father_name_extension,
        'father_middle_name' => $father_middle_name,
        'mother_last_name' => $mother_last_name,
        'mother_first_name' => $mother_first_name,
        'mother_middle_name' => $mother_middle_name
    ];

    return insert('family_backgrounds', $data);
}

function updateFamily($spouse_last_name, $spouse_first_name, $spouse_name_extension, $spouse_middle_name, $spouse_occupation, $spouse_employer, $spouse_employer_address, $spouse_telephone, $father_last_name, $father_first_name, $father_name_extension, $father_middle_name, $mother_last_name, $mother_first_name, $mother_middle_name, $person_id)
{
    $data = [
        'spouse_last_name' => $spouse_last_name,
        'spouse_first_name' => $spouse_first_name,
        'spouse_middle_name' => $spouse_middle_name,
        'spouse_name_extension' => $spouse_name_extension,
        'spouse_occupation' => $spouse_occupation,
        'spouse_employer' => $spouse_employer,
        'spouse_employer_address' => $spouse_employer_address,
        'spouse_telephone' => $spouse_telephone,
        'father_last_name' => $father_last_name,
        'father_first_name' => $father_first_name,
        'father_name_extension' => $father_name_extension,
        'father_middle_name' => $father_middle_name,
        'mother_last_name' => $mother_last_name,
        'mother_first_name' => $mother_first_name,
        'mother_middle_name' => $mother_middle_name
    ];

    return update('family_backgrounds', $data, '`person_id` = ?', [$person_id]);
}

function deleteFamily($person_id)
{
    return delete('family_backgrounds', '`person_id` = ?', [$person_id]);
}

// children
function children($person_id)
{
    $results = query("SELECT * FROM `children` WHERE person_id = ? ORDER BY birthdate ASC", [$person_id]);
    return is_array($results) ? $results : [];
}

function child($person_id, $child_id)
{
    return find("SELECT * FROM `children` WHERE person_id = ? AND `id` = ? LIMIT 1", [$person_id, $child_id]);
}

function createChild($last_name, $first_name, $name_extension, $middle_name, $birthdate, $person_id)
{
    $data = [
        'last_name' => $last_name,
        'first_name' => $first_name,
        'name_extension' => $name_extension,
        'middle_name' => $middle_name,
        'birthdate' => $birthdate,
        'person_id' => $person_id
    ];
    return insert('children', $data);
}

function updateChild($last_name, $first_name, $name_extension, $middle_name, $birthdate, $person_id, $child_id)
{
    $data = [
        'last_name' => $last_name,
        'first_name' => $first_name,
        'name_extension' => $name_extension,
        'middle_name' => $middle_name,
        'birthdate' => $birthdate,
    ];

    return update('children', $data, '`person_id` = ? AND `id` = ?', [$person_id, $child_id]);
}

function deleteChild($person_id, $child_id)
{
    return delete('children', '`person_id` = ? AND `child_id` = ?', [$person_id, $child_id]);
}

function deleteChildren($person_id)
{
    return delete('children', '`person_id` = ?', [$person_id]);
}