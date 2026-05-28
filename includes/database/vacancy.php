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
    $sql = "SELECT va.created_at, ac.code AS application_code, p.official_title
            FROM vacancy_applications AS va
            INNER JOIN application_codes AS ac ON va.application_code_id = ac.id
            INNER JOIN positions AS p ON va.position_id = p.id
            WHERE va.publication_id = ?
            ORDER BY va.created_at DESC";

    return query($sql, [$publicationId]);
}

function applicationsByVacancy($vacancyId)
{
    $sql = "SELECT * FROM `vacancy_applications` 
            WHERE `vacancy_id` = ? 
            ORDER BY `submitted_on` DESC";
    return query($sql, [$vacancyId]);
}

function countApplicationsByPublication($publicationId)
{
    // We stop at vacancy_publication_items because it already has the publication_id
    $sql = "SELECT COUNT(id) AS total 
            FROM vacancy_applications
            WHERE publication_id = ?;";

    $result = find($sql, [$publicationId]);
    return $result ? (int) $result['total'] : 0;
}

// Check if a vacancy is already published in any publication
function isVacancyPublished($vacancy_id)
{
    $result = find("SELECT COUNT(`id`) AS `count` FROM `vacancy_publication_items` WHERE `vacancy_id` = ?", [$vacancy_id]);
    return $result && (int) $result['count'] > 0;
}

function hasAlreadyApplied($publication_id, $application_code_id, $position_id)
{
    $sql = "SELECT id FROM vacancy_applications 
            WHERE publication_id = ? 
            AND application_code_id = ? 
            AND position_id = ? 
            LIMIT 1";
    $result = find($sql, [$publication_id, $application_code_id, $position_id]);
    return !empty($result);
}

function createApplication($publication_id, $application_code_id, $position_id, $district = null)
{
    $data = [
        'publication_id' => $publication_id,
        'application_code_id' => $application_code_id,
        'position_id' => $position_id,
        'district' => $district
    ];
    return insert('vacancy_applications', $data);
}

function applicant($applicant_id)
{
    return find("SELECT * FROM `applicants` WHERE `id` = ? LIMIT 1", [$applicant_id]);
}

function applicantName($application_code, $uppercase = false)
{
    $applicantId = applicantId($application_code);

    if (!$applicantId) {
        return $application_code;
    }

    $data = employee($applicantId);

    if (!$data) {
        $data = applicant($applicantId);
    }

    if ($data) {
        $formattedName = toName(
            $data['last_name'],
            $data['first_name'],
            $data['middle_name'],
            $data['name_extension'],
            true
        );
        if ($uppercase) {
            return strtoupper($formattedName);
        }
        return $formattedName;
    }
    return $application_code;
}

function createApplicant(array $data)
{
    $required = ['id', 'last_name', 'first_name', 'birthdate', 'sex', 'civil_status', 'religion', 'barangay', 'city', 'province', 'zip', 'email_address', 'mobile_number', 'undergraduate'];
    foreach ($required as $field) {
        if (!isset($data[$field]) || $data[$field] === null) {
            return false;
        }
    }
    $data['with_disability'] = isset($data['with_disability']) ? (int) $data['with_disability'] : 0;
    $data['is_indigenous'] = isset($data['is_indigenous']) ? (int) $data['is_indigenous'] : 0;
    if (!isset($data['eligibilities'])) {
        $data['eligibilities'] = json_encode([]);
    } elseif (is_array($data['eligibilities'])) {
        $data['eligibilities'] = json_encode($data['eligibilities']);
    }
    return insert('applicants', $data);
}

function createApplicantCode($applicant_id, $applicant_code)
{
    $data = [
        'id' => $applicant_id,
        'code' => $applicant_code,
    ];
    return insert('application_codes', $data);
}

function applicantEmailExists($email)
{
    return !empty(find("SELECT `id` FROM `applicants` WHERE `email_address` = ?", [$email]));
}

function applicantMobileExists($mobile)
{
    return !empty(find("SELECT `id` FROM `applicants` WHERE `mobile_number` = ?", [$mobile]));
}

function applicantCode($employee_id)
{
    $result = find("SELECT `code` FROM `application_codes` WHERE `id` = ? LIMIT 1", [$employee_id]);
    return $result ? $result['code'] : null;
}

function applicantId($applicant_code)
{
    $result = find("SELECT `id` FROM `application_codes` WHERE `code` = ? LIMIT 1", [$applicant_code]);
    return $result ? $result['id'] : null;
}

function prepareApplicantData(array $post)
{
    $applicant_code = generateID();
    $eligibilities = [];
    if (isset($post['csc_professional']) && $post['csc_professional']) {
        $eligibilities[] = 'CSC Professional';
    }
    if (isset($post['csc_sub_professional']) && $post['csc_sub_professional']) {
        $eligibilities[] = 'CSC Sub-Professional';
    }
    if (isset($post['let_pbet_lept']) && $post['let_pbet_lept']) {
        $eligibilities[] = 'LET/PBET/LEPT';
    }
    if (isset($post['honor_graduate']) && $post['honor_graduate']) {
        $eligibilities[] = 'Honor Graduate Eligibility';
    }
    if (isset($post['barangay_official']) && $post['barangay_official']) {
        $eligibilities[] = 'Barangay Official Eligibility';
    }
    if (isset($post['other_eligibility']) && $post['other_eligibility']) {
        $eligibilities[] = 'Others';
    }
    $data = [
        'id' => $applicant_code,
        'last_name' => sanitize($post['last_name'] ?? null),
        'first_name' => sanitize($post['first_name'] ?? null),
        'middle_name' => sanitize($post['middle_name'] ?? null),
        'name_extension' => sanitize($post['name_extension'] ?? null),
        'birthdate' => sanitize($post['birth_date'] ?? null),
        'sex' => sanitize($post['sex'] ?? null),
        'civil_status' => sanitize($post['civil_status'] ?? null),
        'religion' => sanitize($post['religion'] ?? null),
        'lot' => sanitize($post['lot'] ?? null),
        'street' => sanitize($post['street'] ?? null),
        'subdivision' => sanitize($post['subdivision'] ?? null),
        'barangay' => sanitize($post['barangay'] ?? null),
        'city' => sanitize($post['city'] ?? null),
        'province' => sanitize($post['province'] ?? null),
        'zip' => sanitize($post['zip'] ?? null),
        'with_disability' => isset($post['is_pwd']) ? 1 : 0,
        'is_indigenous' => isset($post['ethnic_group']) && !empty($post['ethnic_group']) ? 1 : 0,
        'indigenous_group' => sanitize($post['ethnic_group'] ?? null),
        'email_address' => sanitize($post['email'] ?? null),
        'mobile_number' => sanitize($post['mobile'] ?? null),
        'undergraduate' => sanitize($post['education'] ?? null),
        'graduate_studies' => sanitize($post['graduate_studies'] ?? null),
        'eligibilities' => json_encode($eligibilities)
    ];
    return $data;
}

function basicDocumentaryRequirements()
{
    return query('SELECT `id`, `code`, `description` FROM `basic_documentary_requirements`');
}

function basicDocumentRequirementId($requirement_code)
{
    $result = find("SELECT `id` FROM `basic_documentary_requirements` WHERE `code` = ?", [$requirement_code]);
    return $result ? $result['id'] : null;
}

function saveVacancyApplicationRequirement($publication_id, $application_code_id, $file_name, $requirement_id)
{
    $data = [
        'publication_id' => $publication_id,
        'application_code_id' => $application_code_id,
        'file_name' => $file_name,
        'requirement_id' => $requirement_id,
    ];
    return insert('vacancy_application_attachments', $data);
}