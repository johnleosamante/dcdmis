<?php
// family_backgrounds
function family($employee_id)
{
    return find("SELECT * FROM `family_backgrounds` WHERE `employee_id` = ? LIMIT 1", [$employee_id]);
}

function createFamily($spouse_last_name, $spouse_first_name, $spouse_name_extension, $spouse_middle_name, $spouse_occupation, $spouse_employer, $spouse_employer_address, $spouse_telephone, $father_last_name, $father_first_name, $father_name_extension, $father_middle_name, $mother_last_name, $mother_first_name, $mother_middle_name, $employee_id)
{
    $data = [
        'employee_id' => $employee_id,
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

function updateFamily($spouse_last_name, $spouse_first_name, $spouse_name_extension, $spouse_middle_name, $spouse_occupation, $spouse_employer, $spouse_employer_address, $spouse_telephone, $father_last_name, $father_first_name, $father_name_extension, $father_middle_name, $mother_last_name, $mother_first_name, $mother_middle_name, $employee_id)
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
    return update('family_backgrounds', $data, '`employee_id` = ?', [$employee_id]);
}

function deleteFamily($employee_id)
{
    return delete('family_backgrounds', '`employee_id` = ?', [$employee_id]);
}

// children
function children($employee_id)
{
    $results = query("SELECT * FROM `children` WHERE employee_id = ? ORDER BY birthdate ASC", [$employee_id]);
    return is_array($results) ? $results : [];
}

function child($employee_id, $child_id)
{
    return find("SELECT * FROM `children` WHERE employee_id = ? AND `id` = ? LIMIT 1", [$employee_id, $child_id]);
}

function createChild($last_name, $first_name, $name_extension, $middle_name, $birthdate, $employee_id)
{
    $data = [
        'last_name' => $last_name,
        'first_name' => $first_name,
        'name_extension' => $name_extension,
        'middle_name' => $middle_name,
        'birthdate' => $birthdate,
        'employee_id' => $employee_id
    ];
    return insert('children', $data);
}

function updateChild($last_name, $first_name, $name_extension, $middle_name, $birthdate, $employee_id, $child_id)
{
    $data = [
        'last_name' => $last_name,
        'first_name' => $first_name,
        'name_extension' => $name_extension,
        'middle_name' => $middle_name,
        'birthdate' => $birthdate
    ];
    return update('children', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $child_id]);
}

function deleteChild($employee_id, $child_id)
{
    return delete('children', '`employee_id` = ? AND `id` = ?', [$employee_id, $child_id]);
}

function deleteChildren($employee_id)
{
    return delete('children', '`employee_id` = ?', [$employee_id]);
}