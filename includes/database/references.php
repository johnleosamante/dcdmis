<?php
// references
function references($employee_id)
{
    $results = query("SELECT * FROM `reference_contacts` WHERE `employee_id` = ? ORDER BY `name` ASC", [$employee_id]);
    return is_array($results) ? $results : [];
}

function reference($employee_id, $reference_id)
{
    return find("SELECT * FROM `reference_contacts` WHERE `employee_id` = ? AND `id` = ? LIMIT 1", [$employee_id, $reference_id]);
}

function createReference($name, $address, $contact, $employee_id)
{
    $data = [
        'name' => $name,
        'address' => $address,
        'contact' => $contact,
        'employee_id' => $employee_id
    ];
    return insert('reference_contacts', $data);
}

function updateReference($name, $address, $contact, $employee_id, $reference_id)
{
    $data = [
        'name' => $name,
        'address' => $address,
        'contact' => $contact
    ];

    return update('reference_contacts', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $reference_id]);
}

function deleteReference($employee_id, $reference_id)
{
    return delete('reference_contacts', '`employee_id` = ? AND `id` = ?', [$employee_id, $reference_id]);
}

function deleteReferences($employee_id)
{
    return delete('reference_contacts', '`employee_id` = ?', [$employee_id]);
}