<?php
// memberships
function memberships($employee_id)
{
    $results = query("SELECT * FROM `memberships` WHERE `employee_id` = ? ORDER BY `organization` ASC", [$employee_id]);
    return is_array($results) ? $results : [];
}

function membership($employee_id, $membership_id)
{
    return find("SELECT * FROM `memberships` WHERE `employee_id` = ? AND `id` = ? LIMIT 1", [$employee_id, $membership_id]);
}

function createMembership($organization, $employee_id)
{
    $data = [
        'organization' => $organization,
        'employee_id' => $employee_id
    ];

    return insert('memberships', $data);
}

function updateMembership($organization, $employee_id, $membership_id)
{
    $data = [
        'organization' => $organization
    ];

    return update('memberships', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $membership_id]);
}

function deleteMembership($employee_id, $membership_id)
{
    return delete('memberships', '`employee_id` = ? AND `id` = ?', [$employee_id, $membership_id]);
}

function deleteMemberships($employee_id)
{
    return delete('memberships', '`employee_id` = ?', [$employee_id]);
}