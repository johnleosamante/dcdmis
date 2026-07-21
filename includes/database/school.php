<?php
// schools
function schools($excludeSDO = false)
{
    if ($excludeSDO) {
        return query("SELECT * FROM `schools` WHERE `id` <> '143' AND `alias` <> 'SDO' ORDER BY `name` ASC");
    }
    return query("SELECT * FROM `schools` ORDER BY `name` ASC");
}

function countSchools()
{
    $sql = "SELECT COUNT(*) AS `count` FROM `schools` WHERE `id` <> '143' AND `alias` <> 'SDO'";
    $result = find($sql);
    return (int) ($result['count'] ?? 0);
}

function districtSchools($district_id)
{
    return query("SELECT * FROM `schools` WHERE district_id = ? ORDER BY `name` ASC", [$district_id]);
}

function schoolsExcept($school_id)
{
    $sql = "SELECT * FROM `schools` WHERE id <> ? ORDER BY `name` ASC";
    return query($sql, [$school_id]);
}

function schoolByAlias($alias)
{
    return find("SELECT * FROM `schools` WHERE alias = ? LIMIT 1", [$alias]);
}

function schoolById($school_id)
{
    return find("SELECT * FROM `schools` WHERE id = ? LIMIT 1", [$school_id]);
}

function schoolsByDistrict($districtId)
{
    return query("SELECT id, `name`, `alias` FROM `schools` WHERE district_id = ? ORDER BY `name` ASC", [$districtId]);
}

function updateSchoolHead($schoolId, $headId)
{
    $data = [
        'head_id' => $headId
    ];
    return update('schools', $data, 'id = ?', [$schoolId]);
}

// employees, station_assignments, schools, districts, positions
function schoolEmployeeCount($school_id = null)
{
    $params = [];
    $filter = "";
    if (isset($school_id)) {
        $filter = " AND s.`id` = ? ";
        $params[] = $school_id;
    }
    $sql = "SELECT s.`id`, 
                SUM(CASE WHEN pos.`category` = 'Teaching' AND p.`sex` = 'Male' THEN 1 ELSE 0 END) AS tmale, 
                SUM(CASE WHEN pos.`category` = 'Teaching-Related' AND p.`sex` = 'Male' THEN 1 ELSE 0 END) AS trmale, 
                SUM(CASE WHEN pos.`category` = 'Non-Teaching' AND p.`sex` = 'Male' THEN 1 ELSE 0 END) AS ntmale, 
                SUM(CASE WHEN p.`sex` = 'Male' THEN 1 ELSE 0 END) AS male, 
                SUM(CASE WHEN pos.`category` = 'Teaching' AND p.`sex` = 'Female' THEN 1 ELSE 0 END) AS tfemale, 
                SUM(CASE WHEN pos.`category` = 'Teaching-Related' AND p.`sex` = 'Female' THEN 1 ELSE 0 END) AS trfemale, 
                SUM(CASE WHEN pos.`category` = 'Non-Teaching' AND p.`sex` = 'Female' THEN 1 ELSE 0 END) AS ntfemale, 
                SUM(CASE WHEN p.`sex` = 'Female' THEN 1 ELSE 0 END) AS female, 
                COUNT(p.`id`) AS total 
            FROM `employees` AS p 
            INNER JOIN `station_assignments` AS sa ON p.`id` = sa.`employee_id` 
            INNER JOIN `schools` AS s ON sa.`station_id` = s.`id` 
            INNER JOIN `districts` AS d ON s.`district_id` = d.`id` 
            INNER JOIN `positions` AS pos ON sa.`position_id` = pos.`id` 
            WHERE p.`status` = 'Active' 
            {$filter} 
            GROUP BY s.`id`, s.`name` 
            ORDER BY d.`name`, s.`category`, s.`name`";
    return find($sql, $params);
}

function createSchool($school_id, $name, $alias, $address, $district_id, $category, $telephone, $email, $website, $fb_page, $logo)
{
    $data = [
        'id' => $school_id,
        'name' => $name,
        'alias' => $alias,
        'address' => $address,
        'district_id' => $district_id,
        'category' => $category,
        'telephone' => $telephone,
        'email' => $email,
        'website' => $website,
        'fb_page' => $fb_page,
        'logo' => $logo
    ];
    return insert('schools', $data);
}

function updateSchool($id, $name, $alias, $address, $district, $category, $telephone, $email, $website, $facebook, $logo, $referenceId)
{
    $data = [
        'id' => $id,
        'name' => $name,
        'alias' => $alias,
        'address' => $address,
        'district_id' => $district,
        'category' => $category,
        'telephone' => $telephone,
        'email' => $email,
        'website' => $website,
        'fb_page' => $facebook,
        'logo' => $logo
    ];
    return update('schools', $data, '`id` = ?', [$referenceId]);
}

function deleteSchool($id)
{
    return delete('schools', '`id` = ?', [$id]);
}

function station($employee_id)
{
    return find("SELECT * FROM `station_assignments` WHERE `employee_id` = ? ORDER BY `assignment_date` DESC LIMIT 1", [$employee_id]);
}

function createStation($assignment_date, $station_id, $position_id, $employee_id)
{
    $data = [
        'assignment_date' => $assignment_date,
        'station_id' => $station_id,
        'position_id' => $position_id,
        'employee_id' => $employee_id
    ];
    return insert('station_assignments', $data);
}

function updateStation($assignment_date, $station_id, $position_id, $employee_id)
{
    $data = [
        'position_id' => $position_id,
        'station_id' => $station_id,
        'assignment_date' => $assignment_date
    ];
    return update('station_assignments', $data, '`employee_id` = ?', [$employee_id]);
}

function deleteStation($id)
{
    return delete('station_assignments', '`employee_id` = ?', [$id]);
}

function updateStationID($new_station_id, $old_station_id)
{
    $data = [
        'station_id' => $new_station_id
    ];
    return update('station_assignments', $data, '`station_id` = ?', [$old_station_id]);
}

function district($district_id)
{
    return find("SELECT * FROM `districts` WHERE `id` = ? LIMIT 1", [$district_id]);
}

function districts($excludeSDO = false)
{
    if ($excludeSDO) {
        return query("SELECT * FROM `districts` WHERE `id` <> 'SDO' ORDER BY `name` ASC");
    }
    return query("SELECT * FROM `districts` ORDER BY `name` ASC");
}

function countDistricts()
{
    $sql = "SELECT COUNT(*) AS `count` FROM `districts` WHERE `id` <> 'SDO'";
    $result = find($sql);
    return (int) ($result['count'] ?? 0);
}

function districtSchoolCount($id)
{
    $sql = "SELECT 
                SUM(CASE WHEN s.`category` = 'Elementary' THEN 1 ELSE 0 END) AS es, 
                SUM(CASE WHEN s.`category` = 'Secondary' THEN 1 ELSE 0 END) AS hs, 
                SUM(CASE WHEN s.`category` = 'Integrated' THEN 1 ELSE 0 END) AS `is`, 
                COUNT(*) AS total 
            FROM `schools` AS s INNER JOIN `districts` AS d ON s.`district_id` = d.`id` WHERE s.`district_id` = ? LIMIT 1";
    return find($sql, [$id]);
}

function createDistrict($district_id, $name, $supervisor_id)
{
    $data = [
        'id' => $district_id,
        'name' => $name,
        'supervisor_id' => $supervisor_id
    ];

    return insert('districts', $data);
}

function updateDistrict($new_district_id, $name, $supervisor_id, $old_district_id)
{
    $data = [
        'id' => $new_district_id,
        'name' => $name,
        'supervisor_id' => $supervisor_id,
    ];
    return update('districts', $data, '`id` = ?', [$old_district_id]);
}

function deleteDistrict($id)
{
    return delete('districts', '`id` = ?', [$id]);
}

function schoolByHead($headId)
{
    return find("SELECT * FROM `schools` WHERE `head_id` = ? LIMIT 1", [$headId]);
}

function isSchoolHeadOfEmployee($headId, $employeeId)
{
    $school = schoolByHead($headId);
    if (!$school) {
        return false;
    }
    $empStation = station($employeeId);
    return $empStation && $empStation['station_id'] === $school['id'];
}