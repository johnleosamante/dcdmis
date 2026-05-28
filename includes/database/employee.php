<?php
// employees
function employee($employee_id)
{
    if (empty($employee_id)) {
        return null;
    }
    return find("SELECT * FROM `employees` WHERE `id` = ? LIMIT 1", [$employee_id]);
}

function findEmployeeByEmail($email)
{
    $data = find("SELECT `id` FROM `employees` WHERE `email_address` = ? LIMIT 1", [$email]);
    return $data ? $data['id'] : null;
}

// employees, station_assignments
function employees()
{
    $sql = "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`, 
                p.`sex`, s.`position_id`, s.`station_id`, p.`profile_picture`, p.`status`
            FROM `employees` AS p
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id` 
            WHERE p.`status` <> 'Duplicate' ORDER BY p.`last_name` ASC";
    $results = query($sql);
    return is_array($results) ? $results : [];
}

// employees
function employeeName($last_name, $first_name, $middle_name, $name_extension)
{
    $sql = "SELECT `id`, `last_name`, `first_name`, `middle_name`, `name_extension` FROM `employees` 
            WHERE `last_name` = ? AND `first_name` = ? AND `middle_name` = ? AND `name_extension` = ? LIMIT 1";
    return find($sql, [$last_name, $first_name, $middle_name, $name_extension]);
}

function employeeContactDetails($employee_id)
{
    return find("SELECT `id`, `email_address`, `alternate_email_address`, `telephone`, `mobile_number`, `alternate_mobile_number` FROM `employees` WHERE `id` = ? LIMIT 1", [$employee_id]);
}

function updateEmployeeContactDetails($alternate_mobile_number, $alternate_email_address, $employee_id)
{
    $data = [
        'alternate_mobile_number' => $alternate_mobile_number,
        'alternate_email_address' => $alternate_email_address
    ];
    return update('employees', $data, '`id` = ?', [$employee_id]);
}

// employees, station_assignments
function districtSupervisors($supervisorRoles = ['PSDS', 'SDS'])
{
    $placeholders = implode(',', array_fill(0, count($supervisorRoles), '?'));
    $sql = "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, 
                p.`name_extension`, s.`position_id` 
            FROM `employees` AS p   
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id` 
            WHERE p.`status` = 'Active' AND s.`position_id` IN ($placeholders) 
            ORDER BY p.`last_name` ASC";
    return query($sql, $supervisorRoles);
}

function activeEmployees($station_id = null)
{
    $params = [];
    $whereClause = "WHERE p.`status` = 'Active'";
    if ($station_id !== null) {
        $whereClause .= " AND s.`station_id` = ?";
        $params[] = $station_id;
    }
    $sql = "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`, 
                p.`sex`, p.`birthdate`, p.`agency_id`, 
                s.`position_id`, s.`station_id`, p.`profile_picture`, 
                p.`email_address`, p.`mobile_number` 
            FROM `employees` AS p
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id` {$whereClause} 
            ORDER BY p.`last_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function countActiveEmployees($station_id = null)
{
    $params = [];
    $whereClause = "WHERE p.`status` = 'Active'";
    if ($station_id !== null) {
        $whereClause .= " AND s.`station_id` = ?";
        $params[] = $station_id;
    }
    $sql = "SELECT COUNT(*) AS `count` FROM `employees` AS p
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id` {$whereClause}";
    $result = find($sql, $params);
    return (int) ($result['count'] ?? 0);
}

function retirableEmployees($station_id = null)
{
    $retirementAge = 60;
    $params = [$retirementAge];

    $sql = "SELECT p.id, p.last_name, p.first_name, p.middle_name, p.name_extension, 
                   p.sex, p.birthdate, p.agency_id, p.profile_picture,
                   TIMESTAMPDIFF(YEAR, p.birthdate, CURDATE()) AS exact_age, 
                   s.position_id, s.station_id 
            FROM employees AS p 
            INNER JOIN station_assignments AS s ON p.id = s.employee_id 
            WHERE p.status = 'Active' 
            AND TIMESTAMPDIFF(YEAR, p.birthdate, CURDATE()) >= ?";

    if ($station_id !== null) {
        $sql .= " AND s.station_id = ?";
        $params[] = $station_id;
    }

    $sql .= " ORDER BY p.birthdate ASC, p.last_name ASC";

    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function countRetirableEmployees($station_id = null)
{
    $currentYear = (int) date('Y');
    $retirementAge = 60;
    $birthYearLimit = $currentYear - $retirementAge;
    $params = [$birthYearLimit];
    $sql = "SELECT COUNT(*) AS `count` FROM `employees` AS p
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id`
            WHERE p.`status` = 'Active' AND YEAR(p.`birthdate`) <= ?";
    if ($station_id !== null) {
        $sql .= " AND s.`station_id` = ?";
        $params[] = $station_id;
    }
    $result = find($sql, $params);
    return (int) ($result['count'] ?? 0);
}

function archivedEmployees($activeStatuses = ['Active', 'Registered'])
{
    $placeholders = implode(',', array_fill(0, count($activeStatuses), '?'));
    $sql = "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`, 
                p.`sex`, p.`birthdate`, p.`agency_id`, 
                s.`position_id`, s.`station_id`, p.`profile_picture`, p.`status`
            FROM `employees` AS p
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id` 
            WHERE p.`status` NOT IN ($placeholders) 
            ORDER BY p.`last_name` ASC";
    $results = query($sql, $activeStatuses);
    return is_array($results) ? $results : [];
}

function employeeSearch($text)
{
    $searchTerm = "%{$text}%";
    $params = [
        $text,
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $text,
        $text,
        $text,
        $text,
        $text,
        $text
    ];
    $sql = "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`,
                p.`sex`, p.`birthdate`, p.`agency_id`, 
                s.`position_id`, s.`station_id`, p.`profile_picture`, p.`status` 
            FROM `employees` AS p 
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id` 
            WHERE p.`id` = ? OR p.`last_name` LIKE ? OR p.`first_name` LIKE ? 
                OR p.`middle_name` LIKE ? OR p.`gsis_crn` = ? OR p.`pagibig` = ? 
                OR p.`philhealth` = ? OR p.`sss` = ? OR p.`tin` = ? OR p.`agency_id` = ? 
            ORDER BY p.`last_name` ASC, p.`first_name` ASC, p.`middle_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

// employees
function employeeGender()
{
    $sql = "SELECT `sex` AS `name`, COUNT(*) AS `count` FROM `employees` 
            WHERE `status` = 'Active' GROUP BY `sex` ORDER BY `sex` DESC";
    return query($sql);
}

// station_assignments, schools, employees, districts
function employeeStation()
{
    $sql = "SELECT s.`name`, COUNT(p.`id`) AS `count` FROM `station_assignments` AS sa 
            INNER JOIN `schools` AS s ON sa.`station_id` = s.`id` 
            INNER JOIN `employees` AS p ON p.`id` = sa.`employee_id` 
            INNER JOIN `districts` AS d ON s.`district_id` = d.`id` 
            WHERE p.`status` = 'Active' GROUP BY s.`id`, s.`name`, s.`name` 
            ORDER BY s.`name` ASC, s.`name` ASC";
    return query($sql);
}

// station_assignments, positions, employees
function employeePosition()
{
    $sql = "SELECT pos.`official_title` AS `name`, COUNT(p.`id`) AS `count` FROM `station_assignments` AS sa 
            INNER JOIN `positions` AS pos ON sa.`position_id` = pos.`id` 
            INNER JOIN `employees` AS p ON p.`id` = sa.`employee_id` 
            WHERE p.`status` = 'Active' GROUP BY pos.`id`, pos.`official_title`, pos.`salary_grade` 
            ORDER BY pos.`salary_grade` DESC, pos.`official_title` ASC";
    return query($sql);
}

function districtEmployee()
{
    $sql = "SELECT d.`name`, COUNT(p.`id`) AS `count` 
            FROM `station_assignments` AS sa 
            INNER JOIN `schools` AS s ON sa.`station_id` = s.`id` 
            INNER JOIN `employees` AS p ON p.`id` = sa.`employee_id` 
            INNER JOIN `districts` AS d ON s.`district_id` = d.`id` 
            WHERE p.`status` = 'Active' GROUP BY d.`id`, d.`name` ORDER BY d.`name` ASC";
    return query($sql);
}

function employeeCategory()
{
    $sql = "SELECT pos.`category` AS `name`, 
                COUNT(p.`id`) AS `count` 
            FROM `positions` AS pos
            INNER JOIN `station_assignments` AS sa ON sa.`position_id` = pos.`id` 
            INNER JOIN `employees` AS p ON p.`id` = sa.`employee_id` 
            WHERE p.`status` = 'Active' GROUP BY pos.`category` ORDER BY pos.`category` ASC";
    return query($sql);
}

function employeeGenderCategory()
{
    $sql = "SELECT `pos`.`category` AS `name`, 
                SUM(CASE WHEN p.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`, 
                SUM(CASE WHEN p.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(p.`id`) AS `total`
            FROM `positions` AS pos 
            INNER JOIN `station_assignments` AS sa ON sa.`position_id` = pos.`id` 
            INNER JOIN `employees` AS p ON p.`id` = sa.`employee_id` 
            WHERE p.`status` = 'Active' GROUP BY pos.`category` ORDER BY pos.`category` ASC";
    return query($sql);
}

function celebrantEmployees($month, $station_id = null)
{
    if ($month < 1 || $month > 12) {
        return [];
    }
    $params = [(int) $month];
    $sql = "SELECT p.`id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`, 
                   p.`sex`, p.`birthdate`, p.`agency_id`, 
                   TIMESTAMPDIFF(YEAR, p.`birthdate`, CURDATE()) AS `current_age`, 
                   sa.`position_id`, sa.`station_id`, p.`profile_picture` 
            FROM `employees` AS p 
            INNER JOIN `station_assignments` AS sa ON p.`id` = sa.`employee_id` 
            WHERE p.`status` = 'Active' 
              AND MONTH(p.`birthdate`) = ?";
    if ($station_id !== null) {
        $sql .= " AND sa.`station_id` = ?";
        $params[] = $station_id;
    }
    $sql .= " ORDER BY DAY(p.`birthdate`) ASC, p.`last_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function createEmployee($employee_id, $last_name, $first_name, $middle_name, $name_extension, $sex, $birthdate, $email_address, $mobile_number, $profile_picture, $status, $gsis_crn = '', $gsis_bp = '', $pagibig = '', $philhealth = '', $tin = '', $agency_id = '')
{
    $data = [
        'id' => $employee_id,
        'last_name' => $last_name,
        'first_name' => $first_name,
        'middle_name' => $middle_name,
        'name_extension' => $name_extension,
        'sex' => $sex,
        'birthdate' => $birthdate,
        'email_address' => $email_address,
        'mobile_number' => $mobile_number,
        'profile_picture' => $profile_picture,
        'status' => $status,
        'gsis_crn' => $gsis_crn,
        'gsis_bp' => $gsis_bp,
        'pagibig' => $pagibig,
        'philhealth' => $philhealth,
        'tin' => $tin,
        'agency_id' => $agency_id
    ];
    return insert('employees', $data);
}

function updateEmployee($last_name, $first_name, $middle_name, $name_extension, $birthdate, $place_of_birth, $sex, $civil_status, $specify_other_civil_status, $religion, $citizenship_id, $dual_citizenship_type, $dual_citizenship_country_id, $residence_lot, $residence_street, $residence_subdivision, $residence_barangay, $residence_city, $residence_province, $residence_zip, $permanent_lot, $permanent_street, $permanent_subdivision, $permanent_barangay, $permanent_city, $permanent_province, $permanent_zip, $height, $weight, $blood_type, $umid, $crn, $bp, $pagibig, $philhealth, $philsys, $sss, $telephone, $mobile, $email, $tin, $agency_id, $prc, $photo, $id)
{
    $data = [
        'last_name' => $last_name,
        'first_name' => $first_name,
        'middle_name' => $middle_name,
        'name_extension' => $name_extension,
        'birthdate' => $birthdate,
        'place_of_birth' => $place_of_birth,
        'sex' => $sex,
        'civil_status' => $civil_status,
        'specify_other_civil_status' => $specify_other_civil_status,
        'religion' => $religion,
        'citizenship_id' => $citizenship_id,
        'dual_citizenship_type' => $dual_citizenship_type,
        'dual_citizenship_country_id' => $dual_citizenship_country_id,
        'residence_lot' => $residence_lot,
        'residence_street' => $residence_street,
        'residence_subdivision' => $residence_subdivision,
        'residence_barangay' => $residence_barangay,
        'residence_city' => $residence_city,
        'residence_province' => $residence_province,
        'residence_zip' => $residence_zip,
        'permanent_lot' => $permanent_lot,
        'permanent_street' => $permanent_street,
        'permanent_subdivision' => $permanent_subdivision,
        'permanent_barangay' => $permanent_barangay,
        'permanent_city' => $permanent_city,
        'permanent_province' => $permanent_province,
        'permanent_zip' => $permanent_zip,
        'height' => $height,
        'weight' => $weight,
        'blood_type' => $blood_type,
        'umid_id' => $umid,
        'gsis_crn' => $crn,
        'gsis_bp' => $bp,
        'pagibig' => $pagibig,
        'philhealth' => $philhealth,
        'philsys' => $philsys,
        'sss' => $sss,
        'telephone' => $telephone,
        'mobile_number' => $mobile,
        'email_address' => $email,
        'tin' => $tin,
        'agency_id' => $agency_id,
        'prc' => $prc,
        'profile_picture' => $photo
    ];
    return update('employees', $data, '`id` = ?', [$id]);
}

function isDuplicateEmployee($id)
{
    $result = find("SELECT `id` FROM `employees` WHERE `id` = ? AND `status` = 'Duplicate' LIMIT 1", [$id]);
    return !empty($result);
}

function deleteEmployee($id)
{
    return delete('employees', '`id` = ?', [$id]);
}

function updateEmployeeStatus($status, $id)
{
    $data = [
        'status' => $status
    ];
    return update('employees', $data, '`id` = ?', [$id]);
}

function updateProfessionalTitles($name_prefix, $name_suffix, $id)
{
    $data = [
        'name_prefix' => $name_prefix,
        'name_suffix' => $name_suffix
    ];
    return update('employees', $data, '`id` = ?', [$id]);
}

function updateProfilePhoto($photo, $id)
{
    $data = [
        'profile_picture' => $photo
    ];
    return update('employees', $data, '`id` = ?', [$id]);
}

function employeePositions()
{
    $sql = "SELECT pos.`official_title`, 
                SUM(CASE WHEN p.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`, 
                SUM(CASE WHEN p.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`, 
                COUNT(p.id) AS `total` 
            FROM `employees` AS p
            INNER JOIN `station_assignments` AS sa ON p.`id` = sa.`employee_id` 
            INNER JOIN `positions` AS pos ON sa.`position_id` = pos.`id` 
            WHERE p.`status` = 'Active' 
            GROUP BY pos.`id`, pos.`official_title`, pos.`salary_grade` 
            ORDER BY pos.`salary_grade` DESC, pos.`official_title` ASC";
    return query($sql);
}