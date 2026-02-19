<?php
// station_assignments, positions, schools
function position($person_id)
{
    $sql = "SELECT sa.`person_id`, sa.`assignment_date`, sa.`position_id`, 
                p.`official_title`, sa.`station_id`, s.`name` AS `station`, sa.`assignment_date`
            FROM `station_assignments` AS sa 
            INNER JOIN `positions` AS p ON p.`id` = sa.`position_id` 
            INNER JOIN `schools` AS s ON sa.`station_id` = s.`id` 
            WHERE sa.`person_id` = ? 
            ORDER BY sa.`assignment_date` DESC LIMIT 1";
    return find($sql, [$person_id]);
}

// positions
function positions($position_id = null)
{
    if ($position_id !== null) {
        $sql = "SELECT * FROM `positions` WHERE id = ? LIMIT 1";
        return find($sql, [$position_id]);
    }
    $sql = "SELECT * FROM `positions` ORDER BY `official_title` ASC";
    return query($sql);
}

function positionCategories()
{
    return query("SELECT category FROM `positions` GROUP BY category ORDER BY category ASC");
}

function positionsByCategory($category)
{
    $sql = "SELECT * FROM `positions` WHERE category = ? ORDER BY salary_grade DESC, `official_title` ASC";
    return query($sql, [$category]);
}