<?php
// references
function references($person_id)
{
    $results = query("SELECT * FROM `references` WHERE `person_id` = ? ORDER BY `name` ASC", [$person_id]);
    return is_array($results) ? $results : [];
}

function reference($person_id, $reference_id)
{
    return find("SELECT * FROM `references` WHERE `person_id` = ? AND `id` = ? LIMIT 1", [$person_id, $reference_id]);
}

function createReference($name, $address, $contact, $person_id)
{
    $data = [
        'name' => $name,
        'address' => $address,
        'contact' => $contact,
        'person_id' => $person_id
    ];
    return insert('references', $data);
}

function updateReference($name, $address, $contact, $person_id, $reference_id)
{
    $data = [
        'name' => $name,
        'address' => $address,
        'contact' => $contact
    ];

    return update('references', $data, '`person_id` = ? AND `id` = ?', [$person_id, $reference_id]);
}

function deleteReference($person_id, $reference_id)
{
    return delete('references', '`person_id` = ? AND `id` = ?', [$person_id, $reference_id]);
}

function deleteReferences($person_id)
{
    return delete('references', '`person_id` = ?', [$person_id]);
}