<?php
// Self-healing database check to ensure required columns exist
try {
    $columnsStatus = query("SHOW COLUMNS FROM `awards_categories_nominees` LIKE 'status'");
    if (empty($columnsStatus)) {
        query("ALTER TABLE `awards_categories_nominees` ADD COLUMN `status` VARCHAR(50) NOT NULL DEFAULT 'Nominated'");
    }
    $columnsType = query("SHOW COLUMNS FROM `awards_categories_nominees` LIKE 'nominee_type'");
    if (empty($columnsType)) {
        query("ALTER TABLE `awards_categories_nominees` ADD COLUMN `nominee_type` VARCHAR(50) NOT NULL DEFAULT 'Employee'");
    }
    $columnsLevel = query("SHOW COLUMNS FROM `awards_categories_nominees` LIKE 'level'");
    if (empty($columnsLevel)) {
        query("ALTER TABLE `awards_categories_nominees` ADD COLUMN `level` VARCHAR(50) NULL AFTER `nominee_type`");
    }
    $colNominatedBy = query("SHOW COLUMNS FROM `awards_categories_nominees` LIKE 'nominated_by'");
    if (empty($colNominatedBy)) {
        query("ALTER TABLE `awards_categories_nominees` ADD COLUMN `nominated_by` VARCHAR(20) NULL AFTER `level`");
    }
    $colNomStart = query("SHOW COLUMNS FROM `award_schedule` LIKE 'nomination_start'");
    if (empty($colNomStart)) {
        query("ALTER TABLE `award_schedule` ADD COLUMN `nomination_start` DATE DEFAULT NULL AFTER `venue`");
    }
    $colNomDeadline = query("SHOW COLUMNS FROM `award_schedule` LIKE 'nomination_deadline'");
    if (empty($colNomDeadline)) {
        query("ALTER TABLE `award_schedule` ADD COLUMN `nomination_deadline` DATE DEFAULT NULL AFTER `nomination_start`");
    }
    // schedule_awards linking table
    $tableExists = query("SHOW TABLES LIKE 'schedule_awards'");
    if (empty($tableExists)) {
        query("CREATE TABLE `schedule_awards` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `schedule_id` INT NOT NULL,
            `award_id` INT NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY `schedule_award_unique` (`schedule_id`, `award_id`)
        )");
    }
    // Always sync: ensure existing schedule-award pairs from nominees are in schedule_awards
    query("INSERT IGNORE INTO `schedule_awards` (`schedule_id`, `award_id`)
           SELECT DISTINCT `schedule_id`, `award_id`
           FROM `awards_categories_nominees`
           WHERE `schedule_id` IS NOT NULL AND `award_id` IS NOT NULL");
    // Self-healing: create ranking_criteria table if not exists
    $rankingCriteriaExists = query("SHOW TABLES LIKE 'ranking_criteria'");
    if (empty($rankingCriteriaExists)) {
        query("CREATE TABLE `ranking_criteria` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `award_id` INT NOT NULL,
            `criterion_name` VARCHAR(255) NOT NULL,
            `max_points` DECIMAL(10,2) NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX `award_id` (`award_id`)
        )");
    }
    // Self-healing: create reusable ranking criteria library if not exists
    $rankingCriteriaLibraryExists = query("SHOW TABLES LIKE 'ranking_criteria_library'");
    if (empty($rankingCriteriaLibraryExists)) {
        query("CREATE TABLE `ranking_criteria_library` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `criterion_name` VARCHAR(255) NOT NULL,
            `default_max_points` DECIMAL(10,2) NOT NULL DEFAULT 10,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY `criterion_name_unique` (`criterion_name`)
        )");
    }
    query("INSERT IGNORE INTO `ranking_criteria_library` (`criterion_name`, `default_max_points`)
           SELECT DISTINCT `criterion_name`, `max_points` FROM `ranking_criteria`");
    // Self-healing: create ranking_scores table if not exists
    $rankingScoresExists = query("SHOW TABLES LIKE 'ranking_scores'");
    if (empty($rankingScoresExists)) {
        query("CREATE TABLE `ranking_scores` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `nominee_id` INT NOT NULL,
            `criterion_id` INT NOT NULL,
            `points` DECIMAL(10,2) NOT NULL DEFAULT 0,
            `ranked_by` VARCHAR(20) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY `nominee_criterion_unique` (`nominee_id`, `criterion_id`),
            INDEX `nominee_id` (`nominee_id`),
            INDEX `criterion_id` (`criterion_id`)
        )");
    }
    // Self-healing: create rankings table if not exists
    $rankingsExists = query("SHOW TABLES LIKE 'rankings'");
    if (empty($rankingsExists)) {
        query("CREATE TABLE `rankings` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `schedule_id` INT NOT NULL,
            `award_id` INT NOT NULL,
            `nominee_id` INT NOT NULL,
            `total_score` DECIMAL(10,2) NOT NULL DEFAULT 0,
            `rank_position` INT NOT NULL DEFAULT 0,
            `status` VARCHAR(50) NOT NULL DEFAULT 'Ranked',
            `ranked_by` VARCHAR(20) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `schedule_award_nominee_unique` (`schedule_id`, `award_id`, `nominee_id`),
            INDEX `schedule_id` (`schedule_id`),
            INDEX `award_id` (`award_id`),
            INDEX `nominee_id` (`nominee_id`)
        )");
    }
} catch (Exception $e) {
    // Fail silently in case of any restriction
}

// recognitions
function recognitions($employee_id)
{
    $results = query("SELECT * FROM `recognitions` WHERE `employee_id` = ? ORDER BY `title` ASC", [$employee_id]);
    return is_array($results) ? $results : [];
}

function recognition($employee_id, $recognition_id)
{
    return find("SELECT * FROM `recognitions` WHERE `employee_id` = ? AND `id` = ? LIMIT 1", [$employee_id, $recognition_id]);
}

function createRecognition($title, $employee_id)
{
    $data = [
        'title' => $title,
        'employee_id' => $employee_id
    ];

    return insert('recognitions', $data);
}

function updateRecognition($title, $employee_id, $recognition_id)
{
    $data = [
        'title' => $title
    ];
    return update('recognitions', $data, '`employee_id` = ? AND `id` = ?', [$employee_id, $recognition_id]);
}

function deleteRecognition($employee_id, $recognition_id)
{
    return delete('recognitions', '`employee_id` = ? AND `id` = ?', [$employee_id, $recognition_id]);
}

function deleteRecognitions($employee_id)
{
    return delete('recognitions', '`employee_id` = ?', [$employee_id]);
}

function employeeAwardedRecognitions($employee_id)
{
    $sql = "SELECT n.`id`, n.`schedule_id`, n.`award_id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`,
                   cat.`name` AS `category_name`,
                   aw.`name` AS `award_name`,
                   s.`title` AS `schedule_title`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `recognition_awards` AS aw ON n.`award_id` = aw.`id`
            LEFT JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            INNER JOIN `award_schedule` AS s ON n.`schedule_id` = s.`id`
            WHERE n.`status` = 'Awarded' 
              AND n.`nominee_type` = 'Employee' 
              AND n.`nominee_id` = ?
            ORDER BY s.`date` DESC, n.`created_at` DESC";
    $results = query($sql, [$employee_id]);
    return is_array($results) ? $results : [];
}

// recognition_categories
function recognitionCategories()
{
    $results = query("SELECT * FROM `recognition_categories` ORDER BY `id` ASC");
    return is_array($results) ? $results : [];
}

function recognitionCategory($category_id)
{
    return find("SELECT * FROM `recognition_categories` WHERE `id` = ? LIMIT 1", [$category_id]);
}

// recognition_awards
function recognitionAwards($category_id = null)
{
    if ($category_id) {
        $results = query("SELECT * FROM `recognition_awards` WHERE `category_id` = ? ORDER BY `id` ASC", [$category_id]);
    } else {
        $results = query("SELECT * FROM `recognition_awards` ORDER BY `id` ASC");
    }
    return is_array($results) ? $results : [];
}

function recognitionAwardsWithCategory()
{
    $sql = "SELECT a.`id`, a.`name`, a.`has_level`, c.`name` AS `category_name`
            FROM `recognition_awards` AS a
            INNER JOIN `recognition_categories` AS c ON a.`category_id` = c.`id`
            ORDER BY a.`created_at` DESC, a.`name` ASC";
    $results = query($sql);
    return is_array($results) ? $results : [];
}

function recognitionAward($award_id)
{
    return find("SELECT * FROM `recognition_awards` WHERE `id` = ? LIMIT 1", [$award_id]);
}

function createRecognitionAward($category_id, $name, $has_level = 0)
{
    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'has_level' => $has_level
    ];
    return insert('recognition_awards', $data);
}

function updateRecognitionAward($id, $category_id, $name, $has_level = 0)
{
    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'has_level' => $has_level
    ];
    return update('recognition_awards', $data, '`id` = ?', [$id]);
}

function updateRecognitionAwardCriteria($id, $criteria)
{
    $data = [
        'criteria' => $criteria
    ];
    return update('recognition_awards', $data, '`id` = ?', [$id]);
}

function deleteRecognitionAward($id)
{
    delete('schedule_awards', '`award_id` = ?', [$id]);
    delete('awards_categories_nominees', '`award_id` = ?', [$id]);
    return delete('recognition_awards', '`id` = ?', [$id]);
}

function activeEmployeesWithPosition($stationId = null, $category = null)
{
    $sql = "SELECT p.`id` AS `employee_id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`,
                pos.`official_title`, pos.`category` AS `position_category`,
                sch.`name` AS `school_name`, sch.`alias` AS `school_alias`
            FROM `employees` AS p
            INNER JOIN (
                SELECT sa1.employee_id, sa1.station_id, sa1.position_id
                FROM station_assignments sa1
                WHERE sa1.created_at = (
                    SELECT MAX(sa2.created_at) FROM station_assignments sa2 WHERE sa2.employee_id = sa1.employee_id
                )
            ) AS s ON p.`id` = s.`employee_id`
            INNER JOIN `positions` AS pos ON s.`position_id` = pos.`id`
            LEFT JOIN `schools` AS sch ON s.`station_id` = sch.`id`
            ";
    $params = [];
    $conditions = [];
    if ($stationId !== null) {
        $conditions[] = "s.`station_id` = ?";
        $params[] = $stationId;
    }
    if ($category !== null && $category !== '') {
        $conditions[] = "pos.`category` = ?";
        $params[] = $category;
    }
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    $sql .= " ORDER BY p.`last_name` ASC, p.`first_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function isPrincipal($userId)
{
    $school = find("SELECT `id` FROM `schools` WHERE `head_id` = ? LIMIT 1", [$userId]);
    return $school !== false;
}

function isDistrictSupervisor($userId)
{
    $pos = position($userId);
    return $pos && isset($pos['position_id']) && $pos['position_id'] === 'PSDS';
}

function districtBySupervisor($userId)
{
    return find("SELECT * FROM `districts` WHERE `supervisor_id` = ? LIMIT 1", [$userId]);
}

function activeEmployeesInDistrict($districtId, $category = null)
{
    $sql = "SELECT p.`id` AS `employee_id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`,
                pos.`official_title`, pos.`category` AS `position_category`,
                sch.`name` AS `school_name`, sch.`alias` AS `school_alias`
            FROM `employees` AS p
            INNER JOIN (
                SELECT sa1.employee_id, sa1.station_id, sa1.position_id
                FROM station_assignments sa1
                WHERE sa1.created_at = (
                    SELECT MAX(sa2.created_at) FROM station_assignments sa2 WHERE sa2.employee_id = sa1.employee_id
                )
            ) AS s ON p.`id` = s.`employee_id`
            INNER JOIN `positions` AS pos ON s.`position_id` = pos.`id`
            INNER JOIN `schools` AS sch ON s.`station_id` = sch.`id`
            WHERE sch.`district_id` = ?";
    $params = [$districtId];
    if ($category !== null && $category !== '') {
        $sql .= " AND pos.`category` = ?";
        $params[] = $category;
    }
    $sql .= " ORDER BY p.`last_name` ASC, p.`first_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function activePrincipalEmployees($stationId = null, $districtId = null)
{
    $sql = "SELECT p.`id` AS `employee_id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`,
                pos.`official_title`, pos.`category` AS `position_category`,
                sch.`name` AS `school_name`, sch.`alias` AS `school_alias`
            FROM `employees` AS p
            INNER JOIN (
                SELECT sa1.employee_id, sa1.station_id, sa1.position_id
                FROM station_assignments sa1
                WHERE sa1.created_at = (
                    SELECT MAX(sa2.created_at) FROM station_assignments sa2 WHERE sa2.employee_id = sa1.employee_id
                )
            ) AS s ON p.`id` = s.`employee_id`
            INNER JOIN `positions` AS pos ON s.`position_id` = pos.`id`
            INNER JOIN `schools` AS sch ON s.`station_id` = sch.`id`
            WHERE LOWER(pos.`official_title`) LIKE '%principal%' AND p.`status` = 'Active'";
    $params = [];
    if ($stationId !== null) {
        $sql .= " AND s.`station_id` = ?";
        $params[] = $stationId;
    }
    if ($districtId !== null) {
        $sql .= " AND sch.`district_id` = ?";
        $params[] = $districtId;
    }
    $sql .= " ORDER BY p.`last_name` ASC, p.`first_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function activeGuidanceCounselorEmployees($stationId = null, $districtId = null)
{
    $sql = "SELECT p.`id` AS `employee_id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`,
                pos.`official_title`, pos.`category` AS `position_category`,
                sch.`name` AS `school_name`, sch.`alias` AS `school_alias`
            FROM `employees` AS p
            INNER JOIN (
                SELECT sa1.employee_id, sa1.station_id, sa1.position_id
                FROM station_assignments sa1
                WHERE sa1.created_at = (
                    SELECT MAX(sa2.created_at) FROM station_assignments sa2 WHERE sa2.employee_id = sa1.employee_id
                )
            ) AS s ON p.`id` = s.`employee_id`
            INNER JOIN `positions` AS pos ON s.`position_id` = pos.`id`
            INNER JOIN `schools` AS sch ON s.`station_id` = sch.`id`
            WHERE LOWER(pos.`official_title`) LIKE '%guidance%' AND p.`status` = 'Active'
              AND (LOWER(pos.`official_title`) LIKE '%counselor%' OR LOWER(pos.`official_title`) LIKE '%councelor%')";
    $params = [];
    if ($stationId !== null) {
        $sql .= " AND s.`station_id` = ?";
        $params[] = $stationId;
    }
    if ($districtId !== null) {
        $sql .= " AND sch.`district_id` = ?";
        $params[] = $districtId;
    }
    $sql .= " ORDER BY p.`last_name` ASC, p.`first_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function awardSchedules()
{
    $results = query("SELECT * FROM `award_schedule` ORDER BY `date` DESC");
    return is_array($results) ? $results : [];
}

function awardSchedule($id)
{
    return find("SELECT * FROM `award_schedule` WHERE `id` = ? LIMIT 1", [$id]);
}

function createAwardSchedule($title, $date, $venue, $nominationStart = null, $nominationDeadline = null)
{
    $data = [
        'title' => $title,
        'date' => $date,
        'venue' => $venue,
        'nomination_start' => $nominationStart,
        'nomination_deadline' => $nominationDeadline
    ];
    return insert('award_schedule', $data);
}

function updateAwardSchedule($title, $date, $venue, $id, $nominationStart = null, $nominationDeadline = null)
{
    $data = [
        'title' => $title,
        'date' => $date,
        'venue' => $venue,
        'nomination_start' => $nominationStart,
        'nomination_deadline' => $nominationDeadline
    ];
    return update('award_schedule', $data, '`id` = ?', [$id]);
}

function isNominationOpen($schedule)
{
    if (empty($schedule['nomination_start']) && empty($schedule['nomination_deadline'])) {
        return true;
    }
    $today = date('Y-m-d');
    if (!empty($schedule['nomination_start']) && $today < $schedule['nomination_start']) {
        return false;
    }
    if (!empty($schedule['nomination_deadline']) && $today > $schedule['nomination_deadline']) {
        return false;
    }
    return true;
}

function nominationStatus($schedule)
{
    if (empty($schedule['nomination_start']) && empty($schedule['nomination_deadline'])) {
        return ['status' => 'open', 'label' => 'Open', 'color' => 'success'];
    }
    $today = date('Y-m-d');
    if (!empty($schedule['nomination_start']) && $today < $schedule['nomination_start']) {
        return ['status' => 'upcoming', 'label' => 'Upcoming', 'color' => 'info'];
    }
    if (!empty($schedule['nomination_deadline']) && $today > $schedule['nomination_deadline']) {
        return ['status' => 'closed', 'label' => 'Closed', 'color' => 'danger'];
    }
    return ['status' => 'open', 'label' => 'Open', 'color' => 'success'];
}

function deleteAwardSchedule($id)
{
    delete('awards_categories_nominees', '`schedule_id` = ?', [$id]);
    delete('schedule_awards', '`schedule_id` = ?', [$id]);
    return delete('award_schedule', '`id` = ?', [$id]);
}

// schedule_awards
function scheduleAwards($schedule_id)
{
    // Every event schedule automatically includes the full, live recognition awards catalog.
    $sql = "SELECT a.`id`, a.`name`, a.`category_id`, a.`has_level`, c.`name` AS `category_name`
            FROM `recognition_awards` AS a
            INNER JOIN `recognition_categories` AS c ON a.`category_id` = c.`id`
            ORDER BY a.`created_at` DESC, a.`name` ASC";
    $results = query($sql);
    return is_array($results) ? $results : [];
}

function nomineesBySchedule($schedule_id)
{
    $sql = "SELECT n.`id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`, n.`nominated_by`,
                   e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   pos.`official_title` AS `position`,
                   cat.`name` AS `category_name`,
                   aw.`name` AS `award_name`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`,
                   nom_e.`first_name` AS `nominator_first`, nom_e.`last_name` AS `nominator_last`,
                   nom_pos.`official_title` AS `nominator_position`, nom_sch.`name` AS `nominator_school`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `station_assignments` AS sa ON e.`id` = sa.`employee_id`
            LEFT JOIN `positions` AS pos ON sa.`position_id` = pos.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `recognition_awards` AS aw ON n.`award_id` = aw.`id`
            LEFT JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            LEFT JOIN `employees` AS nom_e ON n.`nominated_by` = nom_e.`id`
            LEFT JOIN `station_assignments` AS nom_sa ON nom_e.`id` = nom_sa.`employee_id`
            LEFT JOIN `positions` AS nom_pos ON nom_sa.`position_id` = nom_pos.`id`
            LEFT JOIN `schools` AS nom_sch ON nom_sch.`head_id` = nom_e.`id`
            WHERE n.`schedule_id` = ?
            ORDER BY COALESCE(e.`last_name`, sch.`name`) ASC, e.`first_name` ASC";
    $results = query($sql, [$schedule_id]);
    return is_array($results) ? $results : [];
}

function createNominee($schedule_id, $employee_id, $award_id, $nominee_type = 'Employee', $level = null, $nominated_by = null)
{
    $data = [
        'schedule_id' => $schedule_id,
        'nominee_id' => $employee_id, // aligned with nominee_id column
        'award_id' => $award_id,
        'nominee_type' => $nominee_type,
        'level' => $level,
        'nominated_by' => $nominated_by,
        'status' => 'Nominated'
    ];
    return insert('awards_categories_nominees', $data);
}

function deleteNominee($id)
{
    return delete('awards_categories_nominees', '`id` = ?', [$id]);
}

function updateNomineeNominator($nomineeId, $nominatorId)
{
    return update('awards_categories_nominees', ['nominated_by' => $nominatorId], '`id` = ?', [$nomineeId]);
}

function awardWinners()
{
    $sql = "SELECT n.`id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`,
                   e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   pos.`official_title` AS `position`,
                   cat.`name` AS `category_name`,
                   aw.`name` AS `award_name`,
                   s.`title` AS `schedule_title`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `station_assignments` AS sa ON e.`id` = sa.`employee_id`
            LEFT JOIN `positions` AS pos ON sa.`position_id` = pos.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `recognition_awards` AS aw ON n.`award_id` = aw.`id`
            LEFT JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            INNER JOIN `award_schedule` AS s ON n.`schedule_id` = s.`id`
            WHERE n.`status` = 'Awarded'
            ORDER BY s.`date` DESC, COALESCE(e.`last_name`, sch.`name`) ASC, e.`first_name` ASC";
    $results = query($sql);
    return is_array($results) ? $results : [];
}

function nomineesByScheduleAndAward($schedule_id, $award_id)
{
    $sql = "SELECT n.`id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`, n.`nominated_by`,
                   e.`id` AS `employee_id`, e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   pos.`official_title` AS `position`,
                   cat.`name` AS `category_name`,
                   aw.`name` AS `award_name`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`,
                   nom_e.`first_name` AS `nominator_first`, nom_e.`last_name` AS `nominator_last`,
                   nom_pos.`official_title` AS `nominator_position`, nom_sch.`name` AS `nominator_school`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `station_assignments` AS sa ON e.`id` = sa.`employee_id`
            LEFT JOIN `positions` AS pos ON sa.`position_id` = pos.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `recognition_awards` AS aw ON n.`award_id` = aw.`id`
            LEFT JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            LEFT JOIN `employees` AS nom_e ON n.`nominated_by` = nom_e.`id`
            LEFT JOIN `station_assignments` AS nom_sa ON nom_e.`id` = nom_sa.`employee_id`
            LEFT JOIN `positions` AS nom_pos ON nom_sa.`position_id` = nom_pos.`id`
            LEFT JOIN `schools` AS nom_sch ON nom_sch.`head_id` = nom_e.`id`
            WHERE n.`schedule_id` = ? AND n.`award_id` = ?
            ORDER BY COALESCE(e.`last_name`, sch.`name`) ASC, e.`first_name` ASC";
    $results = query($sql, [$schedule_id, $award_id]);
    return is_array($results) ? $results : [];
}

function setAwardWinner($schedule_id, $award_id, $winner_nominee_id)
{
    return query("UPDATE `awards_categories_nominees` SET `status` = 'Awarded' WHERE `id` = ?", [$winner_nominee_id]);
}

function nominee($id)
{
    return find("SELECT * FROM `awards_categories_nominees` WHERE `id` = ? LIMIT 1", [$id]);
}

function nomineeDetails($id)
{
    $sql = "SELECT n.`id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`,
                   e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   pos.`official_title` AS `position`,
                   cat.`name` AS `category_name`,
                   aw.`name` AS `award_name`,
                   s.`title` AS `schedule_title`, s.`date` AS `schedule_date`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `station_assignments` AS sa ON e.`id` = sa.`employee_id`
            LEFT JOIN `positions` AS pos ON sa.`position_id` = pos.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `recognition_awards` AS aw ON n.`award_id` = aw.`id`
            LEFT JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            LEFT JOIN `award_schedule` AS s ON n.`schedule_id` = s.`id`
            WHERE n.`id` = ? LIMIT 1";
    return find($sql, [$id]);
}

function disqualifyNominee($id)
{
    return query("UPDATE `awards_categories_nominees` SET `status` = 'Disqualified' WHERE `id` = ?", [$id]);
}

function nomineesCountByAward($schedule_id)
{
    $sql = "SELECT `award_id`, COUNT(*) AS `cnt` 
            FROM `awards_categories_nominees` 
            WHERE `schedule_id` = ? 
            GROUP BY `award_id`";
    $results = query($sql, [$schedule_id]);
    $counts = [];
    if (is_array($results)) {
        foreach ($results as $row) {
            $counts[$row['award_id']] = $row['cnt'];
        }
    }
    return $counts;
}

function allNominees($filterScheduleId = null, $filterAwardId = null, $filterLevel = null)
{
    $sql = "SELECT n.`id`, n.`schedule_id`, n.`award_id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`, n.`nominated_by`,
                   e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   pos.`official_title` AS `position`,
                   cat.`name` AS `category_name`,
                   aw.`name` AS `award_name`,
                   s.`title` AS `schedule_title`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`,
                   nom_e.`first_name` AS `nominator_first`, nom_e.`last_name` AS `nominator_last`,
                   nom_pos.`official_title` AS `nominator_position`, nom_sch.`name` AS `nominator_school`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `station_assignments` AS sa ON e.`id` = sa.`employee_id`
            LEFT JOIN `positions` AS pos ON sa.`position_id` = pos.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `recognition_awards` AS aw ON n.`award_id` = aw.`id`
            LEFT JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            INNER JOIN `award_schedule` AS s ON n.`schedule_id` = s.`id`
            LEFT JOIN `employees` AS nom_e ON n.`nominated_by` = nom_e.`id`
            LEFT JOIN `station_assignments` AS nom_sa ON nom_e.`id` = nom_sa.`employee_id`
            LEFT JOIN `positions` AS nom_pos ON nom_sa.`position_id` = nom_pos.`id`
            LEFT JOIN `schools` AS nom_sch ON nom_sch.`head_id` = nom_e.`id`
            WHERE 1=1";
    $params = [];
    if ($filterScheduleId) {
        $sql .= " AND n.`schedule_id` = ?";
        $params[] = $filterScheduleId;
    }
    if ($filterAwardId) {
        $sql .= " AND n.`award_id` = ?";
        $params[] = $filterAwardId;
    }
    if ($filterLevel) {
        $sql .= " AND n.`level` = ?";
        $params[] = $filterLevel;
    }
    $sql .= " ORDER BY s.`date` DESC, n.`created_at` DESC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function awardWinnerByScheduleAndAward($schedule_id, $award_id, $level = null)
{
    $params = [$schedule_id, $award_id];
    $levelCond = "";
    if ($level !== null && $level !== '') {
        $levelCond = " AND n.`level` = ?";
        $params[] = $level;
    }
    $sql = "SELECT n.`id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`,
                   e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   pos.`official_title` AS `position`,
                   cat.`name` AS `category_name`,
                   aw.`name` AS `award_name`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `station_assignments` AS sa ON e.`id` = sa.`employee_id`
            LEFT JOIN `positions` AS pos ON sa.`position_id` = pos.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `recognition_awards` AS aw ON n.`award_id` = aw.`id`
            LEFT JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            WHERE n.`schedule_id` = ? AND n.`award_id` = ? AND n.`status` = 'Awarded'{$levelCond}
            LIMIT 1";
    return find($sql, $params);
}

function raceAccessLevel($userId)
{
    $adminPositions = ['SREPS', 'EPS2', 'ITO1'];
    $nominatorPositions = ['SP1', 'SP2', 'SP3', 'SP4', 'ASP2', 'ADOF5', 'PSDS'];
    $pos = position($userId);
    if ($pos && isset($pos['position_id'])) {
        if (in_array($pos['position_id'], $adminPositions)) {
            return 'admin';
        }
    }
    if (userRole($userId, 'RACE')) {
        if ($pos && isset($pos['position_id']) && in_array($pos['position_id'], $nominatorPositions)) {
            return 'nominator';
        }
        return 'nominator';
    }
    return 'none';
}

function isNominatorOnly($userId)
{
    return raceAccessLevel($userId) === 'nominator';
}

function rankingCriteriaByAward($award_id)
{
    $sql = "SELECT * FROM `ranking_criteria` WHERE `award_id` = ? ORDER BY `id` ASC";
    $results = query($sql, [$award_id]);
    return is_array($results) ? $results : [];
}

function rankingCriteriaLibrary()
{
    $results = query("SELECT * FROM `ranking_criteria_library` ORDER BY `criterion_name` ASC");
    return is_array($results) ? $results : [];
}

function rankingCriteriaLibraryById($id)
{
    return find("SELECT * FROM `ranking_criteria_library` WHERE `id` = ? LIMIT 1", [$id]);
}

function rankingCriteriaLibraryIdByName($name)
{
    return find("SELECT * FROM `ranking_criteria_library` WHERE LOWER(`criterion_name`) = LOWER(?) LIMIT 1", [$name]);
}

function saveRankingCriteria($award_id, $criteria)
{
    $existingCriteria = rankingCriteriaByAward($award_id);
    $existingByName = [];
    foreach ($existingCriteria as $existing) {
        $existingByName[strtolower(trim($existing['criterion_name']))] = $existing;
    }

    $savedNames = [];
    foreach ($criteria as $item) {
        $name = trim($item['name'] ?? '');
        $max = floatval($item['max_points'] ?? 0);
        $nameKey = strtolower($name);

        if ($name === '' || $max <= 0 || isset($savedNames[$nameKey])) {
            continue;
        }

        $savedNames[$nameKey] = true;
        if (isset($existingByName[$nameKey])) {
            update('ranking_criteria', ['max_points' => $max], '`id` = ?', [$existingByName[$nameKey]['id']]);
        } else {
            insert('ranking_criteria', [
                'award_id' => $award_id,
                'criterion_name' => $name,
                'max_points' => $max
            ]);
        }

        if (!rankingCriteriaLibraryIdByName($name)) {
            insert('ranking_criteria_library', [
                'criterion_name' => $name,
                'default_max_points' => $max
            ]);
        }
    }

    foreach ($existingCriteria as $existing) {
        $existingName = strtolower(trim($existing['criterion_name']));
        if (!isset($savedNames[$existingName])) {
            delete('ranking_criteria', '`id` = ?', [$existing['id']]);
        }
    }

    return true;
}

function rankingScoresByNominee($nominee_id)
{
    $sql = "SELECT rs.`criterion_id`, rs.`points`, rc.`criterion_name`, rc.`max_points`
            FROM `ranking_scores` AS rs
            INNER JOIN `ranking_criteria` AS rc ON rs.`criterion_id` = rc.`id`
            WHERE rs.`nominee_id` = ?
            ORDER BY rc.`id` ASC";
    $results = query($sql, [$nominee_id]);
    return is_array($results) ? $results : [];
}

function saveRankingScore($nominee_id, $criterion_id, $points, $ranked_by)
{
    $existing = find("SELECT `id` FROM `ranking_scores` WHERE `nominee_id` = ? AND `criterion_id` = ? LIMIT 1", [$nominee_id, $criterion_id]);
    if ($existing) {
        return update('ranking_scores', ['points' => $points, 'ranked_by' => $ranked_by], '`id` = ?', [$existing['id']]);
    } else {
        return insert('ranking_scores', [
            'nominee_id' => $nominee_id,
            'criterion_id' => $criterion_id,
            'points' => $points,
            'ranked_by' => $ranked_by
        ]);
    }
}

function totalScoreByNominee($nominee_id)
{
    $result = find("SELECT COALESCE(SUM(`points`), 0) AS `total` FROM `ranking_scores` WHERE `nominee_id` = ?", [$nominee_id]);
    return $result ? floatval($result['total']) : 0;
}

function awardsWithNominees($schedule_id = null)
{
    $sql = "SELECT aw.`id`, aw.`name`, aw.`category_id`, aw.`has_level`, cat.`name` AS `category_name`,
                   COUNT(n.`id`) AS `nominee_count`
            FROM `recognition_awards` AS aw
            INNER JOIN `recognition_categories` AS cat ON aw.`category_id` = cat.`id`
            INNER JOIN `awards_categories_nominees` AS n ON aw.`id` = n.`award_id`
            WHERE n.`status` != 'Disqualified'";
    $params = [];
    if ($schedule_id) {
        $sql .= " AND n.`schedule_id` = ?";
        $params[] = $schedule_id;
    }
    $sql .= " GROUP BY aw.`id` ORDER BY aw.`name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function nomineesWithScoresByAward($award_id, $schedule_id = null, $level = null)
{
    $sql = "SELECT n.`id`, n.`status`, n.`nominee_type`, n.`nominee_id`, n.`schedule_id`, n.`nominated_by`, n.`level`,
                   e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`,
                   nom_e.`first_name` AS `nominator_first`, nom_e.`last_name` AS `nominator_last`,
                   nom_pos.`official_title` AS `nominator_position`, nom_sch.`name` AS `nominator_school`,
                   COALESCE((
                       SELECT SUM(rs.`points`) FROM `ranking_scores` AS rs
                       INNER JOIN `ranking_criteria` AS rc ON rs.`criterion_id` = rc.`id`
                       WHERE rc.`award_id` = ? AND rs.`nominee_id` = n.`id`
                   ), 0) AS `total_score`
            FROM `awards_categories_nominees` AS n
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `employees` AS nom_e ON n.`nominated_by` = nom_e.`id`
            LEFT JOIN `station_assignments` AS nom_sa ON nom_e.`id` = nom_sa.`employee_id`
            LEFT JOIN `positions` AS nom_pos ON nom_sa.`position_id` = nom_pos.`id`
            LEFT JOIN `schools` AS nom_sch ON nom_sch.`head_id` = nom_e.`id`
            WHERE n.`award_id` = ? AND n.`status` != 'Disqualified'";
    $params = [$award_id, $award_id];
    if ($schedule_id) {
        $sql .= " AND n.`schedule_id` = ?";
        $params[] = $schedule_id;
    }
    if ($level) {
        $sql .= " AND n.`level` = ?";
        $params[] = $level;
    }
    $sql .= " ORDER BY `total_score` DESC, COALESCE(e.`last_name`, sch.`name`) ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function saveFinalRankings($schedule_id, $award_id, $ranked_by = null, $level = null)
{
    $nominees = nomineesWithScoresByAward($award_id, $schedule_id, $level);
    if (empty($nominees)) {
        return false;
    }
    if ($level) {
        query("DELETE r FROM `rankings` AS r
               INNER JOIN `awards_categories_nominees` AS n ON r.`nominee_id` = n.`id`
               WHERE r.`schedule_id` = ? AND r.`award_id` = ? AND n.`level` = ?",
            [$schedule_id, $award_id, $level]
        );
    } else {
        delete('rankings', '`schedule_id` = ? AND `award_id` = ?', [$schedule_id, $award_id]);
    }
    $position = 1;
    $prevScore = null;
    foreach ($nominees as $i => $nom) {
        $score = floatval($nom['total_score']);
        if ($prevScore !== null && $score != $prevScore) {
            $position = $i + 1;
        }
        $prevScore = $score;
        insert('rankings', [
            'schedule_id' => $schedule_id,
            'award_id' => $award_id,
            'nominee_id' => $nom['id'],
            'total_score' => $score,
            'rank_position' => $position,
            'status' => 'Ranked',
            'ranked_by' => $ranked_by
        ]);
    }
    return true;
}

function getRankingsByScheduleAndAward($schedule_id, $award_id, $level = null)
{
    $sql = "SELECT r.`id`, r.`schedule_id`, r.`award_id`, r.`nominee_id`, r.`total_score`, r.`rank_position`, r.`status`, r.`ranked_by`, r.`created_at`, r.`updated_at`,
                   n.`nominee_type`, n.`nominee_id` AS `nominee_ref_id`, n.`level`,
                   e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
                   sch.`name` AS `school_name`, sch.`alias` AS `school_alias`,
                   nom_e.`first_name` AS `nominator_first`, nom_e.`last_name` AS `nominator_last`,
                   nom_pos.`official_title` AS `nominator_position`, nom_sch.`name` AS `nominator_school`
            FROM `rankings` AS r
            INNER JOIN `awards_categories_nominees` AS n ON r.`nominee_id` = n.`id`
            LEFT JOIN `employees` AS e ON n.`nominee_id` = e.`id`
            LEFT JOIN `schools` AS sch ON n.`nominee_id` COLLATE utf8mb4_general_ci = sch.`id` COLLATE utf8mb4_general_ci
            LEFT JOIN `employees` AS nom_e ON n.`nominated_by` = nom_e.`id`
            LEFT JOIN `station_assignments` AS nom_sa ON nom_e.`id` = nom_sa.`employee_id`
            LEFT JOIN `positions` AS nom_pos ON nom_sa.`position_id` = nom_pos.`id`
            LEFT JOIN `schools` AS nom_sch ON nom_sch.`head_id` = nom_e.`id`
            WHERE r.`schedule_id` = ? AND r.`award_id` = ?";
    $params = [$schedule_id, $award_id];
    if ($level) {
        $sql .= " AND n.`level` = ?";
        $params[] = $level;
    }
    $sql .= " ORDER BY r.`rank_position` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function getRankingByNominee($nominee_id)
{
    return find("SELECT * FROM `rankings` WHERE `nominee_id` = ? LIMIT 1", [$nominee_id]);
}

function deleteRankingsByScheduleAndAward($schedule_id, $award_id, $level = null)
{
    if ($level) {
        return query("DELETE r FROM `rankings` AS r
                      INNER JOIN `awards_categories_nominees` AS n ON r.`nominee_id` = n.`id`
                      WHERE r.`schedule_id` = ? AND r.`award_id` = ? AND n.`level` = ?",
            [$schedule_id, $award_id, $level]
        );
    }
    return delete('rankings', '`schedule_id` = ? AND `award_id` = ?', [$schedule_id, $award_id]);
}

function finalizeRankings($schedule_id, $award_id, $level = null)
{
    if ($level) {
        return query("UPDATE `rankings` AS r
                      INNER JOIN `awards_categories_nominees` AS n ON r.`nominee_id` = n.`id`
                      SET r.`status` = 'Finalized'
                      WHERE r.`schedule_id` = ? AND r.`award_id` = ? AND n.`level` = ?",
            [$schedule_id, $award_id, $level]
        );
    }
    return query("UPDATE `rankings` SET `status` = 'Finalized' WHERE `schedule_id` = ? AND `award_id` = ?", [$schedule_id, $award_id]);
}

function hasFinalRankings($schedule_id, $award_id, $level = null)
{
    if ($level) {
        $result = find("SELECT COUNT(*) AS `cnt` FROM `rankings` AS r
                       INNER JOIN `awards_categories_nominees` AS n ON r.`nominee_id` = n.`id`
                       WHERE r.`schedule_id` = ? AND r.`award_id` = ? AND n.`level` = ?
                       LIMIT 1", [$schedule_id, $award_id, $level]);
    } else {
        $result = find("SELECT COUNT(*) AS `cnt` FROM `rankings` WHERE `schedule_id` = ? AND `award_id` = ? LIMIT 1", [$schedule_id, $award_id]);
    }
    return $result && intval($result['cnt']) > 0;
}

function hasNomineeScores($schedule_id, $award_id, $level = null)
{
    $sql = "SELECT COUNT(*) AS `cnt`
            FROM `ranking_scores` AS rs
            INNER JOIN `ranking_criteria` AS rc ON rs.`criterion_id` = rc.`id`
            INNER JOIN `awards_categories_nominees` AS n ON rs.`nominee_id` = n.`id`
            WHERE rc.`award_id` = ? AND n.`schedule_id` = ?";
    $params = [$award_id, $schedule_id];
    if ($level) {
        $sql .= " AND n.`level` = ?";
        $params[] = $level;
    }
    $sql .= " LIMIT 1";
    $result = find($sql, $params);
    return $result && intval($result['cnt']) > 0;
}

function isRankingFinalized($schedule_id, $award_id, $level = null)
{
    if ($level) {
        $result = find("SELECT r.`status` FROM `rankings` AS r
                       INNER JOIN `awards_categories_nominees` AS n ON r.`nominee_id` = n.`id`
                       WHERE r.`schedule_id` = ? AND r.`award_id` = ? AND r.`status` = 'Finalized' AND n.`level` = ?
                       LIMIT 1", [$schedule_id, $award_id, $level]);
    } else {
        $result = find("SELECT `status` FROM `rankings` WHERE `schedule_id` = ? AND `award_id` = ? AND `status` = 'Finalized' LIMIT 1", [$schedule_id, $award_id]);
    }
    return $result !== false;
}

function promoteMasterTeacherWinnerToUlirangGuro($schedule_id, $mt_award_id = null, $ranked_by = null)
{
    if (!$mt_award_id) {
        $mtAward = find("SELECT `id` FROM `recognition_awards`
                         WHERE LOWER(`name`) LIKE '%master teacher%' LIMIT 1");
        if (!$mtAward) {
            return false;
        }
        $mt_award_id = $mtAward['id'];
    }

    $mtAwardRow = find("SELECT `name` FROM `recognition_awards` WHERE `id` = ? LIMIT 1", [$mt_award_id]);
    if (!$mtAwardRow || stripos($mtAwardRow['name'], 'master teacher') === false) {
        return false;
    }

    $winnerCandidates = [];
    $levels = ['Elementary', 'Secondary'];
    foreach ($levels as $lvl) {
        $rankOne = find("SELECT r.`nominee_id`, r.`total_score`, n.`nominee_id` AS `employee_id`, n.`nominee_type`, n.`level`
                         FROM `rankings` AS r
                         INNER JOIN `awards_categories_nominees` AS n ON n.`id` = r.`nominee_id`
                         WHERE r.`schedule_id` = ? AND r.`award_id` = ?
                           AND r.`rank_position` = 1 AND r.`status` = 'Finalized'
                           AND n.`status` = 'Awarded' AND n.`level` = ?
                         ORDER BY r.`id` ASC LIMIT 1", [$schedule_id, $mt_award_id, $lvl]);
        if ($rankOne && strtolower($rankOne['nominee_type']) === 'employee') {
            $rankOne['source_nominee_id'] = $rankOne['nominee_id'];
            $winnerCandidates[$lvl] = $rankOne;
        }
    }

    if (empty($winnerCandidates)) {
        return false;
    }

    $ulirangAward = find("SELECT `id` FROM `recognition_awards`
                          WHERE LOWER(`name`) LIKE '%ulirang guro%' LIMIT 1");
    if (!$ulirangAward) {
        return false;
    }

    $ulirangNomineeIds = [];
    foreach ($winnerCandidates as $lvl => $candidate) {
        $existing = find("SELECT `id` FROM `awards_categories_nominees`
                          WHERE `schedule_id` = ? AND `award_id` = ? AND `nominee_type` = 'Employee' AND `nominee_id` = ?
                          LIMIT 1", [$schedule_id, $ulirangAward['id'], $candidate['employee_id']]);
        if ($existing) {
            $ulirangNomineeIds[$lvl] = [
                'id' => $existing['id'],
                'employee_id' => $candidate['employee_id'],
                'source_nominee_id' => $candidate['source_nominee_id'],
                'total_score' => $candidate['total_score']
            ];
        } else {
            $nomineeId = createNominee($schedule_id, $candidate['employee_id'], $ulirangAward['id'], 'Employee', $lvl, $ranked_by);
            if ($nomineeId) {
                $ulirangNomineeIds[$lvl] = [
                    'id' => $nomineeId,
                    'employee_id' => $candidate['employee_id'],
                    'source_nominee_id' => $candidate['source_nominee_id'],
                    'total_score' => $candidate['total_score']
                ];
            }
        }
    }

    if (count($winnerCandidates) < 2) {
        return false;
    }

    $mtCriteria = rankingCriteriaByAward($mt_award_id);

    $ulirangCriteria = rankingCriteriaByAward($ulirangAward['id']);
    $ulirangCriteriaByName = [];
    foreach ($ulirangCriteria as $uc) {
        $ulirangCriteriaByName[strtolower(trim($uc['criterion_name']))] = $uc;
    }

    $criteriaMap = [];
    foreach ($mtCriteria as $mtCr) {
        $nameKey = strtolower(trim($mtCr['criterion_name']));
        if (isset($ulirangCriteriaByName[$nameKey])) {
            $criteriaMap[$mtCr['id']] = $ulirangCriteriaByName[$nameKey]['id'];
        } else {
            $newCrId = insert('ranking_criteria', [
                'award_id' => $ulirangAward['id'],
                'criterion_name' => $mtCr['criterion_name'],
                'max_points' => $mtCr['max_points']
            ]);
            $criteriaMap[$mtCr['id']] = $newCrId;
        }
    }

    foreach ($ulirangNomineeIds as $nom) {
        $sourceScores = rankingScoresByNominee($nom['source_nominee_id']);
        foreach ($sourceScores as $ss) {
            if (isset($criteriaMap[$ss['criterion_id']])) {
                $newCriterionId = $criteriaMap[$ss['criterion_id']];
                saveRankingScore($nom['id'], $newCriterionId, floatval($ss['points']), $ranked_by);
            }
        }
    }

    delete('rankings', '`schedule_id` = ? AND `award_id` = ?', [$schedule_id, $ulirangAward['id']]);

    $sortedNominees = array_values($ulirangNomineeIds);
    usort($sortedNominees, function ($a, $b) {
        return floatval($b['total_score']) <=> floatval($a['total_score']);
    });

    $position = 1;
    $prevScore = null;
    foreach ($sortedNominees as $i => $nom) {
        $score = floatval($nom['total_score']);
        if ($prevScore !== null && $score != $prevScore) {
            $position = $i + 1;
        }
        $prevScore = $score;
        insert('rankings', [
            'schedule_id' => $schedule_id,
            'award_id' => $ulirangAward['id'],
            'nominee_id' => $nom['id'],
            'total_score' => $score,
            'rank_position' => $position,
            'status' => 'Finalized',
            'ranked_by' => $ranked_by
        ]);
    }

    $winner = $sortedNominees[0];
    foreach ($ulirangNomineeIds as $nom) {
        $status = ((string) $nom['employee_id'] === (string) $winner['employee_id']) ? 'Awarded' : 'Nominated';
        query("UPDATE `awards_categories_nominees` SET `status` = ? WHERE `id` = ?", [$status, $nom['id']]);
    }

    foreach ($ulirangNomineeIds as $nom) {
        if ((string) $nom['employee_id'] === (string) $winner['employee_id']) {
            return $nom['id'];
        }
    }
    return false;
}

function declareWinnerFromRankings($schedule_id, $award_id, $ranked_by = null, $level = null)
{
    saveFinalRankings($schedule_id, $award_id, $ranked_by, $level);
    $rankings = getRankingsByScheduleAndAward($schedule_id, $award_id, $level);
    if (empty($rankings)) {
        return false;
    }
    $winner = null;
    foreach ($rankings as $r) {
        if ($r['rank_position'] == 1) {
            $winner = $r;
            break;
        }
    }
    if (!$winner) {
        $winner = $rankings[0];
    }
    query("UPDATE `awards_categories_nominees` SET `status` = 'Awarded' WHERE `id` = ?", [$winner['nominee_id']]);
    finalizeRankings($schedule_id, $award_id, $level);
    promoteMasterTeacherWinnerToUlirangGuro($schedule_id, $award_id, $ranked_by);
    return $winner['nominee_id'];
}