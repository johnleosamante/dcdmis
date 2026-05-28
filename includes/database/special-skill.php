<?php
// skills
function specialSkills($employee_id)
{
    $results = query("SELECT * FROM `skills` WHERE `employee_id` = ? ORDER BY `name` ASC", [$employee_id]);
    return is_array($results) ? $results : [];
}

function specialSkill($employee_id, $skill_id)
{
    return find("SELECT * FROM `skills` WHERE `employee_id` = ? AND `id` = ? LIMIT 1", [$employee_id, $skill_id]);
}

function createSpecialSkill($name, $employee_id)
{
    $data = [
        'name' => $name,
        'employee_id' => $employee_id
    ];
    return insert('skills', $data);
}

function updateSpecialSkill($name, $employee_id, $no)
{
    $data = [
        'name' => $name
    ];
    return update('skills', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $no]);
}

function deleteSpecialSkill($employee_id, $skill_id)
{
    return delete('skills', '`employee_id` = ? AND `id` = ?', [$employee_id, $skill_id]);
}

function deleteSpecialSkills($employee_id)
{
    return delete('skills', '`employee_id` = ?', [$employee_id]);
}