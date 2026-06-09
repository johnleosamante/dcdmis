<?php
// plantilla_items

function plantillaItem($plantilla_item_id)
{
    return find("SELECT * FROM `plantilla_items` WHERE `id` = ? LIMIT 1", [$plantilla_item_id]);
}

function employeeItemNumber($employee_id)
{
    $sql = "SELECT pi.`id`, pi.`item_number` FROM `service_records` AS  sr
            INNER JOIN `plantilla_items` AS pi ON sr.`plantilla_item_id` = pi.`id`
            WHERE sr.`employee_id` = ? AND sr.`is_present` AND sr.`to_date` IS NULL";

    return find($sql, [$employee_id]);
}

function plantillaItems()
{
    $sql = "SELECT p.`id`, p.`item_number`, p.`employment_status`, p.`is_dissolve`, pos.`official_title`, 
                pos.`salary_grade`, pos.`category`, s.`name` AS `station_name`, s.`id` AS `station_id`,
                CASE WHEN sr.`plantilla_item_id` IS NULL THEN 1 ELSE 0 END AS `is_vacant`
            FROM `plantilla_items` AS p
            INNER JOIN `positions` AS pos ON p.`position_id` = pos.`id`
            INNER JOIN `schools` AS s ON p.`station_id` = s.`id`
            LEFT JOIN `service_records` AS sr ON p.`id` = sr.`plantilla_item_id` 
                AND sr.`is_present` = 1 AND sr.`to_date` IS NULL
            ORDER BY p.`item_number` ASC;";
    return query($sql);
}

function itemPosition($plantilla_item_id)
{
    $sql = "SELECT p.`official_title`, pi.`item_number` FROM `plantilla_items` AS pi
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id`
            WHERE pi.`id` = ?";
    return find($sql, [$plantilla_item_id]);
}

function doesItemNumberExist($item_number, $exclude_id = null)
{
    $sql = "SELECT COUNT(`id`) AS `count` FROM `plantilla_items` WHERE `item_number` = ?";
    $params = [$item_number];

    if ($exclude_id !== null) {
        $sql .= " AND `id` != ?";
        $params[] = $exclude_id;
    }

    $result = find($sql, $params);
    return $result && (int) $result['count'] > 0;
}

function createPlantillaItem($position_id, $item_number, $employment_status, $station_id, $is_dissolve = 0)
{
    $data = [
        'position_id' => $position_id,
        'item_number' => $item_number,
        'employment_status' => $employment_status,
        'station_id' => $station_id,
        'is_dissolve' => $is_dissolve ? 1 : 0
    ];
    return insert('plantilla_items', $data);
}

function updatePlantillaItem($id, $position_id, $item_number, $employment_status, $station_id, $is_dissolve = 0)
{
    $data = [
        'position_id' => $position_id,
        'item_number' => $item_number,
        'employment_status' => $employment_status,
        'station_id' => $station_id,
        'is_dissolve' => $is_dissolve ? 1 : 0
    ];
    return update('plantilla_items', $data, '`id` = ?', [$id]);
}

function deletePlantillaItem($id)
{
    return delete('plantilla_items', '`id` = ?', [$id]);
}

function employeesByStation($station_id, $position_id = null)
{
    $params = [$station_id];
    $positionFilter = '';
    if ($position_id !== null) {
        $positionFilter = ' AND sa.`position_id` = ?';
        $params[] = $position_id;
    }

    // Exclude employees who already occupy any plantilla item with the same position
    // (i.e. they have a present service record linked to a plantilla item of that position)
    $excludeFilter = '';
    if ($position_id !== null) {
        $excludeFilter = " AND e.`id` NOT IN (
                SELECT sr.`employee_id`
                FROM `service_records` AS sr
                INNER JOIN `plantilla_items` AS pi ON sr.`plantilla_item_id` = pi.`id`
                WHERE pi.`position_id` = ? AND sr.`is_present` = 1 AND sr.`to_date` IS NULL
            )";
        $params[] = $position_id;
    }

    $sql = "SELECT e.`id`, e.`last_name`, e.`first_name`, e.`middle_name`, e.`name_extension`,
                sa.`assignment_date`, sa.`position_id`, p.`official_title` AS `position_title`
            FROM `employees` AS e
            INNER JOIN `station_assignments` AS sa ON e.`id` = sa.`employee_id`
            INNER JOIN `positions` AS p ON sa.`position_id` = p.`id`
            WHERE e.`status` = 'Active' AND sa.`station_id` = ?{$positionFilter}{$excludeFilter}
            ORDER BY e.`last_name` ASC, e.`first_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}