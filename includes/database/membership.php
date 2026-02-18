<?php
// memberships
function memberships($person_id)
{
    $results = query("SELECT * FROM `memberships` WHERE `person_id` = ? ORDER BY `organization` ASC", [$person_id]);
    return is_array($results) ? $results : [];
}

function membership($person_id, $membership_id)
{
    return find("SELECT * FROM `memberships` WHERE `person_id` = ? AND `id` = ? LIMIT 1", [$person_id, $membership_id]);
}

function createMembership($organization, $person_id)
{
    $data = [
        'organization' => $organization,
        'person_id' => $person_id
    ];

    return insert('memberships', $data);
}

function updateMembership($organization, $person_id, $membership_id)
{
    $data = [
        'organization' => $organization
    ];

    return update('memberships', $data, '`person_id` = ? AND `id` = ?', [$person_id, $membership_id]);
}

function deleteMembership($person_id, $membership_id)
{
    return delete('memberships', '`person_id` = ? AND `id` = ?', [$person_id, $membership_id]);
}

function deleteMemberships($person_id)
{
    return delete('memberships', '`person_id` = ?', [$person_id]);
}