<?php
// station_assignments, positions, schools
function position($employee_id)
{
    $sql = "SELECT sa.`employee_id`, sa.`assignment_date`, sa.`position_id`, 
                p.`official_title`, p.`salary_grade`, sa.`station_id`, s.`name` AS `station`, sa.`assignment_date`
            FROM `station_assignments` AS sa 
            INNER JOIN `positions` AS p ON p.`id` = sa.`position_id` 
            INNER JOIN `schools` AS s ON sa.`station_id` = s.`id` 
            WHERE sa.`employee_id` = ? 
            ORDER BY sa.`assignment_date` DESC LIMIT 1";
    return find($sql, [$employee_id]);
}

// positions
function positions($position_id = null)
{
    if ($position_id !== null) {
        $sql = "SELECT `id`, `official_title`, `salary_grade`, `category` FROM `positions` WHERE id = ? LIMIT 1";
        return find($sql, [$position_id]);
    }
    $sql = "SELECT * FROM `positions` ORDER BY `official_title` ASC";
    return query($sql);
}

function positionCategories()
{
    return query("SELECT category FROM `positions` GROUP BY category ORDER BY category ASC");
}

function positionsByCategory($category, $salary_grade = null)
{
    $sql = "SELECT `id`, `official_title`, `salary_grade`, `category` FROM `positions` WHERE category = ?";
    $params = [$category];
    if ($salary_grade !== null) {
        $sql .= " AND salary_grade >= ?";
        $params[] = $salary_grade;
    }
    $sql .= " ORDER BY salary_grade DESC, `official_title` ASC";
    return query($sql, $params);
}

function createPosition($position_id, $official_title, $salary_grade, $category)
{
    $data = [
        'id' => $position_id,
        'official_title' => $official_title,
        'salary_grade' => $salary_grade,
        'category' => $category
    ];
    return insert('positions', $data);
}

function updatePosition($position_id, $official_title, $salary_grade, $category, $reference_position_id)
{
    $data = [
        'id' => $position_id,
        'official_title' => $official_title,
        'salary_grade' => $salary_grade,
        'category' => $category
    ];
    return update('positions', $data, '`id` = ?', [$reference_position_id]);
}

function deletePosition($position_id)
{
    return delete('positions', '`id` = ?', [$position_id]);
}