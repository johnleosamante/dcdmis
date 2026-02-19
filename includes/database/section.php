<?php
// functional_divisions
function functionalDivisions()
{
    return query("SELECT * FROM `functional_divisions` ORDER BY `name` ASC");
}

function functionalDivision($functional_division_id)
{
    return find("SELECT * FROM `functional_divisions` WHERE `id` = ? LIMIT 1", [$functional_division_id]);
}

// functional_divisions, sections
function sections($functional_division_id = null)
{
    $params = [];
    $where = "";
    if (!empty($functional_division_id)) {
        $where = " WHERE s.`functional_division_id` = ? ";
        $params[] = $functional_division_id;
    }
    $sql = "SELECT s.`id`, s.`head_id`, s.`name`, f.`name` AS `functional_division` FROM `sections` AS s 
            INNER JOIN `functional_divisions` AS f ON s.functional_division_id = f.`id` 
            {$where} ORDER BY s.`name` ASC";
    return query($sql, $params);
}

// sections
function section($section_id)
{
    return find("SELECT * FROM `sections` WHERE `id` = ? LIMIT 1", [$section_id]);
}

function sectionsExcept($section_id)
{
    return query("SELECT * FROM `sections` WHERE `id` <> ? ORDER BY `name` ASC", [$section_id]);
}

// persons, user_permissions, sections
function sectionEmployeeCount($id)
{
    $sql = "SELECT 
                SUM(CASE WHEN p.`sex` = 'Male' THEN 1 ELSE 0 END) AS male, 
                SUM(CASE WHEN p.`sex` = 'Female' THEN 1 ELSE 0 END) AS female, 
                COUNT(p.`id`) AS total 
            FROM `persons` AS p 
            INNER JOIN `user_permissions` AS u ON p.`id` = u.`person_id` 
            INNER JOIN `sections` AS s ON u.`access` = s.`id` 
            WHERE p.`status` = 'Active' AND u.`access` = ? GROUP BY s.`name` LIMIT 1";
    return find($sql, [$id]);
}

// sections
function createSection($section_id, $head_id, $name, $functional_division_id)
{
    $data = [
        'id' => $section_id,
        'head_id' => $head_id,
        'name' => $name,
        'functional_division_id' => $functional_division_id
    ];
    return insert('sections', $data);
}

function updateSection($new_section_id, $head_id, $name, $functional_division_id, $old_section_id)
{
    $data = [
        'id' => $new_section_id,
        'head_id' => $head_id,
        'name' => $name,
        'functional_division_id' => $functional_division_id
    ];
    return update('sections', $data, '`id` = ?', [$old_section_id]);
}