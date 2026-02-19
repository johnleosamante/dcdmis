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
        'person_id' => $person_id
    ];
    return insert('skills', $data);
}

function updateSpecialSkill($name, $person_id, $no)
{
    return update('skills', ['name' => $name], '`person_id` = ? AND `id` = ?', [$person_id, $no]);
}

function deleteSpecialSkill($person_id, $skill_id)
{
    return delete('skills', '`person_id` = ? AND `id` = ?', [$person_id, $skill_id]);
}

function deleteSpecialSkills($person_id)
{
    return delete('skills', '`person_id` = ?', [$person_id]);
}