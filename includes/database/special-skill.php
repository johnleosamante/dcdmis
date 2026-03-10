<?php
// skills
function specialSkills($person_id)
{
    $results = query("SELECT * FROM `skills` WHERE `person_id` = ? ORDER BY `name` ASC", [$person_id]);
    return is_array($results) ? $results : [];
}

function specialSkill($person_id, $skill_id)
{
    return find("SELECT * FROM `skills` WHERE `person_id` = ? AND `id` = ? LIMIT 1", [$person_id, $skill_id]);
}

function createSpecialSkill($name, $person_id)
{
    $data = [
        'name' => $name,
        'person_id' => $person_id,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return insert('skills', $data);
}

function updateSpecialSkill($name, $person_id, $no)
{
    $data = [
        'name' => $name,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return update('skills', $data, '`person_id` = ? AND `id` = ?', [$person_id, $no]);
}

function deleteSpecialSkill($person_id, $skill_id)
{
    return delete('skills', '`person_id` = ? AND `id` = ?', [$person_id, $skill_id]);
}

function deleteSpecialSkills($person_id)
{
    return delete('skills', '`person_id` = ?', [$person_id]);
}