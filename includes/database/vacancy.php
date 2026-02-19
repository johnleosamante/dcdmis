<?php
// vacancies
function vacancy($vacancy_id)
{
    return find("SELECT * FROM `vacancies` WHERE `id` = ? LIMIT 1", [$vacancy_id]);
}

function doesItemNumberExist($item_number)
{
    $result = query("SELECT * FROM `vacancies` WHERE `item_number` = ? LIMIT 1", [$item_number]);
    return count($result ?: []) > 0;
}

function createVacancy($status, $position_id, $station_id, $item_number, $vacated_by, $date_vacated, $reason)
{
    $data = [
        'status' => $status,
        'position_id' => $position_id,
        'station_id' => $station_id,
        'item_number' => $item_number,
        'vacated_by' => $vacated_by,
        'date_vacated' => $date_vacated,
        'reason' => $reason
    ];
    return insert('vacancies', $data);
}

function updateVacancy($vacancy_id, $status, $position_id, $station_id, $item_number, $date_vacated, $reason)
{
    $data = [
        'status' => $status,
        'position_id' => $position_id,
        'station_id' => $station_id,
        'item_number' => $item_number,
        'date_vacated' => $date_vacated,
        'reason' => $reason
    ];
    return update('vacancies', $data, '`id` = ?', [$vacancy_id]);
}

function updateFilledVacancy($vacancy_id)
{
    return update('vacancies', ['status' => 'filled'], '`id` = ?', [$vacancy_id]);
}

// vacancies, positions
function vacancies($status = 'open')
{
    $sql = "SELECT v.`id`, v.`status`, p.`official_title`, v.`station_id`, 
                v.`item_number`,  v.`vacated_by`, 
                v.`date_vacated`, v.`reason`, v.`created_at`, v.`updated_at` 
            FROM `vacancies` AS v 
            INNER JOIN `positions` AS p ON v.`position_id` = p.`id` 
            WHERE v.`status` = ? ORDER BY v.`created_at` DESC";
    return query($sql, [$status]);
}

// vacancy_publications
function publications()
{
    return query("SELECT * FROM `vacancy_publications` ORDER BY `open_date` DESC");
}

// vacancies
function deleteVacancy($vacancy_id)
{
    return delete('vacancies', '`id` = ?', [$vacancy_id]);
}

function fillVacancy($vacancy_id)
{
    return update('vacancies', ['status' => 'filled'], '`id` = ?', [$vacancy_id]);
}

// vacancies, positions
function vacanciesByStatus($status)
{
    $sql = "SELECT v.`id`, v.`status`, v.`position_id`, p.`official_title`, p.`salary_grade`, 
                v.`station_id`, v.`item_number`, v.`vacated_by`, v.`date_vacated`, v.`reason`, 
                v.`created_at`, v.`updated_at` 
            FROM `vacancies` AS v 
            INNER JOIN `positions` AS p ON v.`position_id` = p.`official_title` 
            WHERE v.`status` = ? ORDER BY p.`official_title` ASC";
    return query($sql, [$status]);
}

// vacancy_publications, vacancy_publication_items, vacancies, positions
function vacantItems($position_id = null)
{
    $params = [];
    $filter = "";
    if ($position_id !== null) {
        $filter = " AND v.`position_id` = ? ";
        $params[] = $position_id;
    }
    $sql = "SELECT v.`id`, v.`status`, v.`position_id`, p.`official_title`, p.`category`, 
                p.`salary_grade`, v.`station_id`, v.`item_number`, v.`vacated_by`, 
                v.`date_vacated`, v.`reason`, v.`created_at`, (
                    SELECT vp.`code` FROM `vacancy_publications` AS vp 
                    INNER JOIN `vacancy_publication_items` AS vpi ON vp.`id` = vpi.`publication_id` 
                    WHERE vpi.`vacancy_id` = v.`id` LIMIT 1
                ) AS `publication_code` 
            FROM `vacancies` AS v 
            INNER JOIN `positions` AS p ON v.`position_id` = p.`id` 
            WHERE v.`status` = 'open' {$filter} ORDER BY p.`official_title` ASC";
    return query($sql, $params);
}

// vacancies
function countVacanciesByStatus($status)
{
    $result = find("SELECT COUNT(`id`) AS total` FROM `vacancies` WHERE `status` = ?", [$status]);
    return $result ? (int) $result['total'] : 0;
}

// vacancies, positions
function allVacancies()
{
    $sql = "SELECT v.`id`, v.`status`, v.`position_id`, p.`official_title`, 
                p.`salary_grade`, v.`station_id`, `v.`item_number`, v.`vacated_by`, 
                v.`date_vacated`, v.`reason`, v.`created_at`, v.`updated_at` 
            FROM `vacancies` AS v 
            INNER JOIN `positions` AS p ON v.`position_id` = p.`id` 
            ORDER BY v.`status` ASC, p.`official_title` ASC";
    return query($sql);
}

function vacanciesGroupedByPosition()
{
    $sql = "SELECT v.`position_id`, p.`official_title`, p.`category`, p.``salary_grade`, 
                COUNT(v.`id`) AS `count` 
            FROM `vacancies` AS v 
            INNER JOIN `positions` AS p ON v.`position_id` = p.`id` 
            WHERE v.`status` = 'open' 
            GROUP BY v.`position_id`, p.`official_title`, p.`category`, p.`salary_grade` 
            ORDER BY p.`official_title` ASC";
    return query($sql);
}

// vacancies
function vacanciesByPositionId($position_id)
{
    $sql = "SELECT `id` FROM `vacancies` WHERE `status` = 'open' AND `position_id` = ?";
    return query($sql, [$position_id]);
}

// vacancy_publications
function generatePublicationCode()
{
    $year = date('Y');
    $sql = "SELECT COUNT(*) AS `count` FROM `vacancy_publications` WHERE YEAR(`created_on`) = ?";
    $result = find($sql, [$year]);
    $count = ($result ? (int) $result['count'] : 0) + 1;
    return 'PUB' . $year . str_pad($count, 3, '0', STR_PAD_LEFT);
}

function publication($id)
{
    return find("SELECT * FROM `vacancy_publications` WHERE `id` = ? LIMIT 1", [$id]);
}

function publicationByCode($code)
{
    return find("SELECT * FROM `vacancy_publications` WHERE `code` = ? LIMIT 1", [$code]);
}

function activePublications()
{
    $sql = "SELECT * FROM `vacancy_publications` WHERE `status` = 'open' AND `close_date` >= CURDATE() 
            ORDER BY `created_on` DESC";
    return query($sql);
}

function allPublications()
{
    $sql = "SELECT * FROM `vacancy_publications` ORDER BY `created_at` DESC";
    return query($sql);
}

function createPublication($code, $title, $description, $open_date, $close_date, $status)
{
    $data = [
        'code' => $code,
        'title' => $title,
        'description' => $description,
        'open_date' => $open_date,
        'close_date' => $close_date,
        'status' => $status
    ];
    return insert('vacancy_publications', $data);
}

function updatePublication($vacancy_publication_id, $title, $description, $open_date, $close_date, $status)
{
    $data = [
        'title' => $title,
        'description' => $description,
        'open_date' => $open_date,
        'close_date' => $close_date,
        'status' => $status
    ];
    return update('vacancy_publications', $data, '`id` = ?', [$vacancy_publication_id]);
}

function deletePublication($vacancy_publication_id)
{
    return delete('vacancy_publications', '`id` = ?', [$vacancy_publication_id]);
}

function countPublications()
{
    $sql = "SELECT COUNT(`id`) AS `total` FROM `vacancy_publications`";
    $result = find($sql);
    return $result ? (int) $result['total'] : 0;
}

// vacancy_publication_items, vacancies, positions
function publicationItems($publication_id)
{
    $sql = "SELECT vpi.`id`, vpi.`vacancy_id`, v.`position_id`, v.`item_number`, 
                p.`official_title`, p.`salary_grade`, v.`station_id`, v.`reason` 
            FROM `vacancy_publication_items` AS vpi 
            INNER JOIN `vacancies` AS v ON vpi.`vacancy_id` = v.`id` 
            INNER JOIN `positions` AS p ON v.`position_id` = p.`id` 
            WHERE vpi.`publication_id` = ? ORDER BY p.`official_title` ASC";
    return query($sql, [$publication_id]);
}

// vacancy_publication_items
function addPublicationItem($publication_id, $vacancy_id, $position_id, $plantilla_item_id)
{
    $data = [
        'publication_id' => $publication_id,
        'vacancy_id' => $vacancy_id,
        'position_id' => $position_id,
        'plantilla_item_id' => $plantilla_item_id
    ];

    return insert('vacancy_publication_items', $data);
}

// vacancy_publication_items
function removePublicationItem($publication_id, $vacancy_id, $position_id, $plantilla_item_id)
{
    return delete('vacancy_publication_items', '`publication_id` = ? AND `vacancy_id` = ? AND `position_id` = ? AND `plantilla_item_id` = ?', [$publication_id, $vacancy_id, $position_id, $plantilla_item_id]);
}

function clearPublicationItems($publication_id)
{
    return delete('vacancy_publication_items', '`publication_id` = ?', [$publication_id]);
}

function countPublicationItems($publication_id)
{
    $sql = "SELECT COUNT(`id`) AS `total` FROM `vacancy_publication_items` WHERE `publication_id` = ?";
    $result = find($sql, [$publication_id]);
    return $result ? (int) $result['total'] : 0;
}

// vacancy_applications
function application($id)
{
    $sql = "SELECT va.*, p.`official_title`, v.`item_number`, v.`station_id` 
            FROM `vacancy_applications` AS va 
            INNER JOIN `vacancies` AS v ON va.`vacancy_id` = v.`id` 
            INNER JOIN `positions` AS p ON v.position_id = p.`id` 
            WHERE va.`id` = ? LIMIT 1";
    return find($sql, [$id]);
}

// TODO
function applicationsByPublication($publicationId)
{
    $sql = "SELECT va.`id`, va.`created_at`, va.email, va.mobile, va.resume_path, va.status,
                COALESCE(NULLIF(va.applicant_name, ''), CONCAT(a.first_name, ' ', a.last_name)) AS applicant_name,
                v.psipop AS item_number, 
                j.Job_description AS position 
            FROM `vacancy_applications` AS va 
            LEFT JOIN `vacancies` AS v ON va.vacancy_id = v.id 
            LEFT JOIN `tbl_job` AS j ON v.position_id = j.Job_code 
            LEFT JOIN `applicants` AS a ON va.applicant_id = a.id
            WHERE va.publication_id = ? 
            ORDER BY va.`created_at` DESC";
    return query($sql, [$publicationId]);
}


function applicationsByVacancy($vacancyId)
{
    $sql = "SELECT * FROM `vacancy_applications` 
            WHERE `vacancy_id` = ? 
            ORDER BY `submitted_on` DESC";
    return query($sql, [$vacancyId]);
}

function vacanciesByPublicationAndPosition($publicationId, $positionId)
{
    $sql = "SELECT vpi.vacancy_id 
            FROM `vacancy_publication_items` AS vpi 
            INNER JOIN `vacancies` AS v ON vpi.vacancy_id = v.id 
            WHERE vpi.publication_id = ? 
            AND v.position_id = ? 
            AND v.status = 'open'";
    return query($sql, [$publicationId, $positionId]);
}

function generateApplicantCode()
{
    $year = date('Y');
    $prefix = "APP-{$year}-";
    $sql = "SELECT `applicant_code` FROM `applicants` 
            WHERE `applicant_code` LIKE ? 
            ORDER BY `id` DESC LIMIT 1";
    $last = find($sql, ["{$prefix}%"]);
    if ($last) {
        $lastNum = (int) str_replace($prefix, '', $last['applicant_code']);
        $newNum = $lastNum + 1;
    } else {
        $newNum = 1;
    }
    return $prefix . str_pad($newNum, 5, '0', STR_PAD_LEFT);
}

function findApplicantByEmail($email)
{
    return find("SELECT * FROM `applicants` WHERE `email` = ? LIMIT 1", [$email]);
}

function findApplicantByEmployeeId($employeeId)
{
    return find("SELECT * FROM `applicants` WHERE `person_id` = ? LIMIT 1", [$employeeId]);
}

function createApplicant($code, $fname, $mname, $lname, $ext, $email, $mobile, $isEmployee, $employeeId, $resumePath, $sex = null, $dob = null, $civil = null, $address = null, $religion = null, $pwd = 0, $ethnic = null, $education = null, $eligibility = null)
{
    $data = [
        'applicant_code' => $code,
        'first_name' => $fname,
        'middle_name' => $mname,
        'last_name' => $lname,
        'ext_name' => $ext,
        'email' => $email,
        'mobile' => $mobile,
        'is_employee' => $isEmployee ? 1 : 0,
        'person_id' => $employeeId,
        'resume_path' => $resumePath,
        'sex' => $sex,
        'birth_date' => $dob,
        'civil_status' => $civil,
        'address' => $address,
        'religion' => $religion,
        'is_pwd' => $pwd ? 1 : 0,
        'ethnic_group' => $ethnic,
        'education' => $education,
        'eligibility' => $eligibility
    ];
    return insert('applicants', $data);
}

function updateApplicant($id, $fname, $mname, $lname, $ext, $mobile, $resumePath, $sex = null, $dob = null, $civil = null, $address = null, $religion = null, $pwd = 0, $ethnic = null, $education = null, $eligibility = null)
{
    $data = [
        'first_name' => $fname,
        'middle_name' => $mname,
        'last_name' => $lname,
        'ext_name' => $ext,
        'mobile' => $mobile,
        'resume_path' => $resumePath,
        'sex' => $sex,
        'birth_date' => $dob,
        'civil_status' => $civil,
        'address' => $address,
        'religion' => $religion,
        'is_pwd' => $pwd ? 1 : 0,
        'ethnic_group' => $ethnic,
        'education' => $education,
        'eligibility' => $eligibility
    ];
    return update('applicants', $data, '`id` = ?', [$id]);
}

function createApplicationEntry($publicationId, $vacancyId, $applicantId)
{
    $check = find("SELECT `id` FROM `vacancy_applications` WHERE `vacancy_id` = ? AND `applicant_id` = ?", [$vacancyId, $applicantId]);
    if ($check) {
        return true;
    }
    $app = find("SELECT * FROM `applicants` WHERE `id` = ?", [$applicantId]);
    if (!$app) {
        return false;
    }
    require_once root() . '/includes/string.php';
    $fullName = toName($app['last_name'], $app['first_name'], $app['middle_name'], $app['ext_name']);
    $data = [
        'publication_id' => $publicationId,
        'vacancy_id' => $vacancyId,
        'applicant_id' => $applicantId,
        'applicant_name' => $fullName,
        'email' => $app['email'],
        'mobile' => $app['mobile'],
        'resume_path' => $app['resume_path'],
        'status' => 'pending',
        'submitted_on' => date('Y-m-d H:i:s')
    ];
    return insert('vacancy_applications', $data);
}

function createApplication($publicationId, $vacancyId, $applicantName, $email, $mobile, $resumePath, $employeeId = null)
{
    $data = [
        'publication_id' => $publicationId,
        'vacancy_id' => $vacancyId,
        'person_id' => $employeeId,
        'applicant_name' => $applicantName,
        'email' => $email,
        'mobile' => $mobile,
        'resume_path' => $resumePath,
        'status' => 'pending',
        'submitted_on' => date('Y-m-d H:i:s')
    ];
    return insert('vacancy_applications', $data);
}

function updateApplicationStatus($id, $status)
{
    return update('vacancy_applications', ['status' => $status], '`id` = ?', [$id]);
}

function countApplicationsByPublication($publicationId)
{
    $sql = "SELECT COUNT(`id`) AS total FROM `vacancy_applications` WHERE `publication_id` = ?";
    $res = find($sql, [$publicationId]);
    return $res ? (int) $res['total'] : 0;
}

function countApplicationsByStatus($publicationId, $status)
{
    $sql = "SELECT COUNT(`id`) AS total FROM `vacancy_applications` WHERE `publication_id` = ? AND `status` = ?";
    $res = find($sql, [$publicationId, $status]);
    return $res ? (int) $res['total'] : 0;
}