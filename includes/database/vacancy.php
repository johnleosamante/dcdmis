<?php
// vacancies
function vacancy($vacancy_id)
{
    $sql = "SELECT v.`id`, pi.`item_number`, p.`official_title` FROM `vacancies` as V 
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id` 
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id` WHERE v.`id` = ?";
    return find($sql, [$vacancy_id]);
}

// vacancies, plantilla_items, positions
function vacancies($status = 'open')
{
    $sql = "SELECT v.`id`, pi.`item_number`, p.`official_title`, pi.`station_id`, v.`status`, 
                v.`vacated_by_id`, 
                v.`date_vacated`, v.`reason`, v.`created_at`, v.`updated_at` 
            FROM `vacancies` AS v
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id` 
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id` 
            WHERE v.`status` = ? ORDER BY v.`created_at` DESC";
    return query($sql, [$status]);
}

function countVacantItems($position_id = null)
{
    $params = [];
    $filter = "";
    if ($position_id !== null) {
        $filter = " AND pi.`position_id` = ? ";
        $params[] = $position_id;
    }
    $sql = "SELECT COUNT(*) as total
            FROM `vacancies` AS v 
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id` 
            WHERE v.`status` = 'open' 
            AND v.`id` NOT IN (SELECT `vacancy_id` FROM `vacancy_publication_items`)
            {$filter}";
    $result = find($sql, $params);
    return (int) ($result['total'] ?? 0);
}

function createVacancy($plantilla_item_id, $status, $vacated_by_id, $date_vacated, $reason)
{
    $data = [
        'plantilla_item_id' => $plantilla_item_id,
        'status' => $status,
        'vacated_by_id' => $vacated_by_id,
        'date_vacated' => $date_vacated,
        'reason' => $reason
    ];
    return insert('vacancies', $data);
}

function vacantItem($plantilla_item_id)
{
    $result = find("SELECT `id` FROM `vacancies` WHERE `plantilla_item_id`=?", [$plantilla_item_id]);
    return $result > 0;
}

function publicationCodes($vacancy_id)
{
    $sql = "SELECT vp.`code` FROM `vacancy_publication_items` AS vpi 
            INNER JOIN `vacancy_publications` AS vp ON vpi.`publication_id` = vp.`id` 
            WHERE `vpi`.`vacancy_id` = ?;";
    return query($sql, [$vacancy_id]);
}

// vacancies
function deleteVacancy($vacancy_id)
{
    return delete('vacancies', '`id` = ?', [$vacancy_id]);
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

// vacancies - for new publication (open and not yet published)
function vacantItems($position_id = null)
{
    $params = [];
    $filter = "";
    if ($position_id !== null) {
        $filter = " AND pi.`position_id` = ? ";
        $params[] = $position_id;
    }
    $sql = "SELECT v.`id`, pi.`position_id`, p.`official_title`, p.`category`, 
                p.`salary_grade`, pi.`station_id`, pi.`item_number`, v.`vacated_by_id`, 
                v.`date_vacated`, v.`reason`, v.`created_at`
            FROM `vacancies` AS v 
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id`
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id` 
            WHERE v.`status` = 'open' 
            AND v.`id` NOT IN (SELECT `vacancy_id` FROM `vacancy_publication_items`)
            {$filter} ORDER BY p.`official_title` ASC";
    return query($sql, $params);
}

// vacancies - for updating publication (already added items + open and not yet published)
function vacantItemsForUpdate($publication_id, $position_id = null)
{
    $params = [$publication_id];
    $filter = "";
    if ($position_id !== null) {
        $filter = " AND pi.`position_id` = ? ";
        $params[] = $position_id;
    }
    $sql = "SELECT v.`id`, pi.`position_id`, p.`official_title`, p.`category`, 
                p.`salary_grade`, pi.`station_id`, pi.`item_number`, v.`vacated_by_id`, 
                v.`date_vacated`, v.`reason`, v.`created_at`
            FROM `vacancies` AS v 
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id`
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id` 
            WHERE v.`status` = 'open' 
            AND (
                v.`id` IN (SELECT `vacancy_id` FROM `vacancy_publication_items` WHERE `publication_id` = ?)
                OR v.`id` NOT IN (SELECT `vacancy_id` FROM `vacancy_publication_items`)
            )
            {$filter} ORDER BY p.`official_title` ASC";
    return query($sql, $params);
}

function vacantPlantillaItems()
{
    $sql = "SELECT p.`id`, p.`item_number`, p.`position_id`, p.`station_id`,
                pos.`official_title`, pos.`salary_grade`, pos.`category`,
                s.`name` AS `station_name`
            FROM `plantilla_items` AS p
            INNER JOIN `positions` AS pos ON p.`position_id` = pos.`id`
            INNER JOIN `schools` AS s ON p.`station_id` = s.`id`
            WHERE p.`is_dissolve` = 0 AND p.`id` NOT IN (SELECT `plantilla_item_id` FROM `vacancies`)
            ORDER BY pos.`category` ASC, pos.`official_title` ASC, p.`item_number` ASC";
    return query($sql);
}

// vacancy_publications
function generatePublicationCode()
{
    $year = date('Y');
    $sql = "SELECT COUNT(*) AS `count` FROM `vacancy_publications` WHERE YEAR(`created_at`) = ?";
    $result = find($sql, [$year]);
    $count = ($result ? (int) $result['count'] : 0) + 1;
    return "PUB{$year}" . str_pad($count, 3, '0', STR_PAD_LEFT);
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
            ORDER BY `created_at` DESC";
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
    $sql = "SELECT vpi.`id`, vpi.`vacancy_id`, pi.`position_id`, p.`official_title`, pi.`item_number`, p.`salary_grade`,
                pi.`station_id`, v.`date_vacated`, v.`reason` 
            FROM `vacancy_publication_items` AS vpi 
            INNER JOIN `vacancies` AS v ON vpi.`vacancy_id` = v.`id` 
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id` 
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id` 
            WHERE vpi.`publication_id` = ? ORDER BY p.`official_title` ASC";
    return query($sql, [$publication_id]);
}

// vacancy_publication_items
function addPublicationItem($publication_id, $vacancy_id)
{
    $data = [
        'publication_id' => $publication_id,
        'vacancy_id' => $vacancy_id
    ];
    return insert('vacancy_publication_items', $data);
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

function applicantsByPublication($publicationId)
{
    $sql = "SELECT 
                va.`created_at`,
                ac.`code` AS application_code, 
                p.`official_title`
            FROM `vacancy_applications` AS va 
            INNER JOIN `application_codes` AS ac ON va.`application_code_id` = ac.`id`
            INNER JOIN `vacancy_publication_items` AS vpi ON va.`publication_item_id` = vpi.`id`
            INNER JOIN `vacancies` AS v ON vpi.`vacancy_id` = v.`id`
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id`
            INNER JOIN `positions` AS p ON pi.`position_id` = p.`id`
            WHERE vpi.`publication_id` = ? 
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

// function vacanciesByPublicationAndPosition($publicationId, $positionId)
// {
//     $sql = "SELECT vpi.vacancy_id 
//             FROM `vacancy_publication_items` AS vpi 
//             INNER JOIN `vacancies` AS v ON vpi.vacancy_id = v.id 
//             WHERE vpi.publication_id = ? 
//             AND v.position_id = ? 
//             AND v.status = 'open'";
//     return query($sql, [$publicationId, $positionId]);
// }

// function generateApplicantCode()
// {
//     $year = date('Y');
//     $prefix = "APP-{$year}-";
//     $sql = "SELECT `applicant_code` FROM `applicants` 
//             WHERE `applicant_code` LIKE ? 
//             ORDER BY `id` DESC LIMIT 1";
//     $last = find($sql, ["{$prefix}%"]);
//     if ($last) {
//         $lastNum = (int) str_replace($prefix, '', $last['applicant_code']);
//         $newNum = $lastNum + 1;
//     } else {
//         $newNum = 1;
//     }
//     return $prefix . str_pad($newNum, 5, '0', STR_PAD_LEFT);
// }

// function findApplicantByEmail($email)
// {
//     return find("SELECT * FROM `applicants` WHERE `email` = ? LIMIT 1", [$email]);
// }

// function findApplicantByEmployeeId($employeeId)
// {
//     return find("SELECT * FROM `applicants` WHERE `employee_id` = ? LIMIT 1", [$employeeId]);
// }

// function createApplicant($code, $fname, $mname, $lname, $ext, $email, $mobile, $isEmployee, $employeeId, $resumePath, $sex = null, $dob = null, $civil = null, $address = null, $religion = null, $pwd = 0, $ethnic = null, $education = null, $eligibility = null)
// {
//     $data = [
//         'applicant_code' => $code,
//         'first_name' => $fname,
//         'middle_name' => $mname,
//         'last_name' => $lname,
//         'ext_name' => $ext,
//         'email' => $email,
//         'mobile' => $mobile,
//         'is_employee' => $isEmployee ? 1 : 0,
//         'employee_id' => $employeeId,
//         'resume_path' => $resumePath,
//         'sex' => $sex,
//         'birth_date' => $dob,
//         'civil_status' => $civil,
//         'address' => $address,
//         'religion' => $religion,
//         'is_pwd' => $pwd ? 1 : 0,
//         'ethnic_group' => $ethnic,
//         'education' => $education,
//         'eligibility' => $eligibility
//     ];
//     return insert('applicants', $data);
// }

// function updateApplicant($id, $fname, $mname, $lname, $ext, $mobile, $resumePath, $sex = null, $dob = null, $civil = null, $address = null, $religion = null, $pwd = 0, $ethnic = null, $education = null, $eligibility = null)
// {
//     $data = [
//         'first_name' => $fname,
//         'middle_name' => $mname,
//         'last_name' => $lname,
//         'ext_name' => $ext,
//         'mobile' => $mobile,
//         'resume_path' => $resumePath,
//         'sex' => $sex,
//         'birth_date' => $dob,
//         'civil_status' => $civil,
//         'address' => $address,
//         'religion' => $religion,
//         'is_pwd' => $pwd ? 1 : 0,
//         'ethnic_group' => $ethnic,
//         'education' => $education,
//         'eligibility' => $eligibility
//     ];
//     return update('applicants', $data, '`id` = ?', [$id]);
// }

// function createApplicationEntry($publicationId, $vacancyId, $applicantId)
// {
//     $check = find("SELECT `id` FROM `vacancy_applications` WHERE `vacancy_id` = ? AND `applicant_id` = ?", [$vacancyId, $applicantId]);
//     if ($check) {
//         return true;
//     }
//     $app = find("SELECT * FROM `applicants` WHERE `id` = ?", [$applicantId]);
//     if (!$app) {
//         return false;
//     }
//     require_once root() . '/includes/string.php';
//     $fullName = toName($app['last_name'], $app['first_name'], $app['middle_name'], $app['ext_name']);
//     $data = [
//         'publication_id' => $publicationId,
//         'vacancy_id' => $vacancyId,
//         'applicant_id' => $applicantId,
//         'applicant_name' => $fullName,
//         'email' => $app['email'],
//         'mobile' => $app['mobile'],
//         'resume_path' => $app['resume_path'],
//         'status' => 'pending',
//         'submitted_on' => date('Y-m-d H:i:s')
//     ];
//     return insert('vacancy_applications', $data);
// }

// function createApplication($publicationId, $vacancyId, $applicantName, $email, $mobile, $resumePath, $employeeId = null)
// {
//     $data = [
//         'publication_id' => $publicationId,
//         'vacancy_id' => $vacancyId,
//         'employee_id' => $employeeId,
//         'applicant_name' => $applicantName,
//         'email' => $email,
//         'mobile' => $mobile,
//         'resume_path' => $resumePath,
//         'status' => 'pending',
//         'submitted_on' => date('Y-m-d H:i:s')
//     ];
//     return insert('vacancy_applications', $data);
// }

// function updateApplicationStatus($id, $status)
// {
//     $data = [
//         'status' => $status
//     ];
//     return update('vacancy_applications', $data, '`id` = ?', [$id]);
// }

function countApplicationsByPublication($publicationId)
{
    $sql = "SELECT COUNT(va.`id`) AS `total` FROM `vacancy_applications` AS va 
            INNER JOIN `vacancy_publication_items` AS vpi ON va.`publication_item_id` = vpi.`id` 
            INNER JOIN `vacancy_publications` AS vp ON vpi.`publication_id` = vp.`id` 
            WHERE vpi.`publication_id` = ?;";
    $result = find($sql, [$publicationId]);
    return $result ? (int) $result['total'] : 0;
}

// function countApplicationsByStatus($publicationId, $status)
// {
//     $sql = "SELECT COUNT(`id`) AS total FROM `vacancy_applications` WHERE `publication_id` = ? AND `status` = ?";
//     $res = find($sql, [$publicationId, $status]);
//     return $res ? (int) $res['total'] : 0;
// }

// Check if a vacancy is already published in any publication
function isVacancyPublished($vacancy_id)
{
    $result = find("SELECT COUNT(`id`) AS `count` FROM `vacancy_publication_items` WHERE `vacancy_id` = ?", [$vacancy_id]);
    return $result && (int) $result['count'] > 0;
}