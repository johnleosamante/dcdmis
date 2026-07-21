<?php
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
    $sql = "SELECT a.`id`, a.`name`, c.`name` AS `category_name`
            FROM `recognition_awards` AS a
            INNER JOIN `recognition_categories` AS c ON a.`category_id` = c.`id`
            ORDER BY a.`id` ASC";
    $results = query($sql);
    return is_array($results) ? $results : [];
}

function recognitionAward($award_id)
{
    return find("SELECT * FROM `recognition_awards` WHERE `id` = ? LIMIT 1", [$award_id]);
}

function createRecognitionAward($category_id, $name)
{
    $data = [
        'category_id' => $category_id,
        'name' => $name
    ];
    return insert('recognition_awards', $data);
}

function activeEmployeesWithPosition($stationId = null)
{
    $sql = "SELECT p.`id` AS `employee_id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`,
                pos.`official_title`
            FROM `employees` AS p
            INNER JOIN `station_assignments` AS s ON p.`id` = s.`employee_id`
            INNER JOIN `positions` AS pos ON s.`position_id` = pos.`id`
            ";
    $params = [];
    if ($stationId !== null) {
        $sql .= " WHERE s.`station_id` = ?";
        $params[] = $stationId;
    }
    $sql .= " ORDER BY p.`last_name` ASC, p.`first_name` ASC";
    $results = query($sql, $params);
    return is_array($results) ? $results : [];
}

function isPrincipal($userId)
{
    $principalPositions = ['SP1', 'SP2', 'SP3', 'SP4', 'ASP2'];
    $pos = position($userId);
    return $pos && isset($pos['position_id']) && in_array($pos['position_id'], $principalPositions);
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
    return delete('award_schedule', '`id` = ?', [$id]);
}

function nomineesBySchedule($schedule_id)
{
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
            WHERE n.`schedule_id` = ?
            ORDER BY COALESCE(e.`last_name`, sch.`name`) ASC, e.`first_name` ASC";
    $results = query($sql, [$schedule_id]);
    return is_array($results) ? $results : [];
}

function createNominee($schedule_id, $employee_id, $award_id, $nominee_type = 'Employee', $level = null)
{
    $data = [
        'schedule_id' => $schedule_id,
        'nominee_id' => $employee_id, // aligned with nominee_id column
        'award_id' => $award_id,
        'nominee_type' => $nominee_type,
        'level' => $level,
        'status' => 'Nominated'
    ];
    return insert('awards_categories_nominees', $data);
}

function deleteNominee($id)
{
    return delete('awards_categories_nominees', '`id` = ?', [$id]);
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
    $sql = "SELECT n.`id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`,
                   e.`id` AS `employee_id`, e.`first_name`, e.`middle_name`, e.`last_name`, e.`name_extension`,
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
    $sql = "SELECT n.`id`, n.`schedule_id`, n.`award_id`, n.`status`, n.`created_at`, n.`nominee_type`, n.`nominee_id`, n.`level`,
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
    $adminPositions = ['SREPS', 'ITO1'];
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