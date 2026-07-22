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

// vacancies, positions, plantilla_items, vacancy_history
function vacanciesByStatus($status)
{
    if ($status === 'filled') {
        $sql = "SELECT vh.`id`, vh.`date_filled`, vh.`filled_by_id` AS `filled_by`,
                       pi.`item_number`, pi.`station_id`,
                       pos.`official_title` AS `position`, pos.`salary_grade`
                FROM `vacancy_history` AS vh
                INNER JOIN `plantilla_items` AS pi ON vh.`plantilla_item_id` = pi.`id`
                INNER JOIN `positions` AS pos ON pi.`position_id` = pos.`id`
                ORDER BY vh.`date_filled` DESC, pos.`official_title` ASC";
        return query($sql);
    }

    $sql = "SELECT v.`id`, v.`status`, pi.`item_number`, pi.`station_id`,
                   pos.`official_title` AS `position`, pos.`salary_grade`
            FROM `vacancies` AS v
            INNER JOIN `plantilla_items` AS pi ON v.`plantilla_item_id` = pi.`id`
            INNER JOIN `positions` AS pos ON pi.`position_id` = pos.`id`
            WHERE v.`status` = ?
            ORDER BY pos.`official_title` ASC";
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
    return "CFA{$year}" . str_pad($count, 3, '0', STR_PAD_LEFT);
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
            ORDER BY `close_date` DESC";
    return query($sql);
}

function allPublications()
{
    $sql = "SELECT * FROM `vacancy_publications` ORDER BY `close_date` DESC, `created_at` DESC";
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
                pi.`station_id`, v.`date_vacated`, v.`reason`, v.`status` 
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
    $sql = "SELECT va.id, va.created_at, ac.code AS application_code, p.official_title, p.category AS position_group,
                   va.status, va.application_code_id,
                   va.remarks, s.total_accumulated_score
            FROM vacancy_applications AS va
            INNER JOIN application_codes AS ac ON va.application_code_id = ac.id
            INNER JOIN positions AS p ON va.position_id = p.id
            LEFT JOIN assessment_scores AS s ON va.id = s.application_id
            WHERE va.publication_id = ?
            ORDER BY p.category ASC, p.official_title ASC, va.created_at DESC";

    return query($sql, [$publicationId]);
}

function applicantsForReviewByPublication($publicationId)
{
    $sql = "SELECT va.id, va.created_at, ac.code AS application_code, p.official_title, va.status, va.application_code_id,
                   s.total_accumulated_score
            FROM vacancy_applications AS va
            INNER JOIN application_codes AS ac ON va.application_code_id = ac.id
            INNER JOIN positions AS p ON va.position_id = p.id
            LEFT JOIN assessment_scores AS s ON va.id = s.application_id
            WHERE va.publication_id = ? AND va.status = 'For Review' 
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
    $sql = "SELECT COUNT(id) AS total 
            FROM vacancy_applications
            WHERE publication_id = ?;";
    $result = find($sql, [$publicationId]);
    return $result ? (int) $result['total'] : 0;
}

function countApplicantsByPublication($publicationId)
{
    $sql = "SELECT COUNT(DISTINCT `application_code_id`) AS total 
            FROM vacancy_applications
            WHERE publication_id = ?";
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
    $required = ['id', 'last_name', 'first_name', 'birthdate', 'sex', 'civil_status', 'barangay', 'city', 'province', 'zip', 'email_address', 'mobile_number', 'undergraduate'];
    foreach ($required as $field) {
        if (!isset($data[$field]) || $data[$field] === null) {
            return false;
        }
    }
    if (empty($data['religion_id']) && empty($data['specify_other_religion'])) {
        return false;
    }
    $data['with_disability'] = isset($data['with_disability']) ? (int) $data['with_disability'] : 0;
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

    $raw_religion = sanitize($post['religion_id'] ?? null);
    $religion_id = null;
    $specify_other_religion = null;
    if ($raw_religion === 'Others') {
        $specify_other_religion = sanitize($post['specify_other_religion'] ?? null);
    } else {
        $religion_id = !empty($raw_religion) ? (int) $raw_religion : null;
    }

    $raw_ethnic = sanitize($post['ethnic_group'] ?? null);
    $ethnic_group_id = null;
    $specify_other_ethnic_group = null;
    if ($raw_ethnic === 'Others') {
        $specify_other_ethnic_group = sanitize($post['ethnic_group_specify'] ?? null);
    } elseif ($raw_ethnic === 'Not Applicable') {
        $specify_other_ethnic_group = 'Not Applicable';
        $ethnic_group_id = null;
    } else {
        $ethnic_group_id = !empty($raw_ethnic) ? (int) $raw_ethnic : null;
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
        'religion_id' => $religion_id,
        'specify_other_religion' => $specify_other_religion,
        'ethnic_group_id' => $ethnic_group_id,
        'specify_other_ethnic_group' => $specify_other_ethnic_group,
        'lot' => sanitize($post['lot'] ?? null),
        'street' => sanitize($post['street'] ?? null),
        'subdivision' => sanitize($post['subdivision'] ?? null),
        'barangay' => sanitize($post['barangay'] ?? null),
        'city' => sanitize($post['city'] ?? null),
        'province' => sanitize($post['province'] ?? null),
        'zip' => sanitize($post['zip'] ?? null),
        'with_disability' => isset($post['is_pwd']) ? 1 : 0,
        'email_address' => sanitize($post['email'] ?? null),
        'mobile_number' => sanitize($post['mobile'] ?? null),
        'undergraduate' => sanitize($post['education'] ?? null),
        'graduate_studies' => sanitize($post['graduate_studies'] ?? null),
        'eligibilities' => json_encode($eligibilities)
    ];
    return $data;
}

function saveVacancyApplicationRequirement($publication_id, $application_code_id, $file_name)
{
    $data = [
        'publication_id' => $publication_id,
        'application_code_id' => $application_code_id,
        'file_name' => $file_name
    ];
    return insert('vacancy_application_attachments', $data);
}

function applicantDocument(int $publication_id, int $application_code_id): ?string
{
    $sql = "SELECT `file_name` FROM `vacancy_application_attachments` 
            WHERE `publication_id` = ? AND `application_code_id` = ?
            ORDER BY `created_at` DESC LIMIT 1";
    $result = find($sql, [$publication_id, $application_code_id]);
    return $result['file_name'] ?? null;
}

function applicationRecord($applicationId)
{
    return find("SELECT * FROM `vacancy_applications` WHERE `id` = ?", [$applicationId]);
}

function qualifyApplication($applicationId)
{
    $data = [
        'status' => 'Qualified',
        'remarks' => null
    ];
    return update('vacancy_applications', $data, '`id` = ?', [$applicationId]);
}

function disqualifyApplication($applicationId, $remarks = null)
{
    $data = [
        'status' => 'Disqualified',
        'remarks' => $remarks
    ];
    return update('vacancy_applications', $data, '`id` = ?', [$applicationId]);
}

function forReviewApplication($applicationId)
{
    $data = [
        'status' => 'For Review',
        'remarks' => null
    ];
    return update('vacancy_applications', $data, '`id` = ?', [$applicationId]);
}

function getAssessmentScore($applicationId)
{
    return find("SELECT * FROM `assessment_scores` WHERE `application_id` = ?", [$applicationId]);
}

function saveAssessmentScore($applicationId, array $data)
{
    $existing = find("SELECT `id` FROM `assessment_scores` WHERE `application_id` = ?", [$applicationId]);
    if ($existing) {
        return update('assessment_scores', $data, '`application_id` = ?', [$applicationId]);
    } else {
        $data['application_id'] = $applicationId;
        return insert('assessment_scores', $data);
    }
}

function qualifiedApplicantsAssessmentResults($publicationId)
{
    $sql = "SELECT 
                va.id AS application_id,
                va.created_at,
                ac.code AS application_code,
                va.application_code_id,
                p.id AS position_id,
                p.official_title,
                p.category AS position_group,
                p.salary_grade,
                s.education_score,
                s.training_score,
                s.experience_score,
                s.performance_score,
                s.outstanding_accomplishments_score,
                s.application_of_education_score,
                s.application_of_ld_score,
                s.potential_written_exam_raw,
                s.potential_bei_raw,
                s.potential_wst_raw,
                s.potential_final_score,
                s.total_accumulated_score,
                s.hrmspb_remarks
            FROM vacancy_applications AS va
            INNER JOIN application_codes AS ac ON va.application_code_id = ac.id
            INNER JOIN positions AS p ON va.position_id = p.id
            LEFT JOIN assessment_scores AS s ON va.id = s.application_id
            WHERE va.publication_id = ? AND va.status = 'Qualified'
            ORDER BY s.total_accumulated_score DESC, ac.code ASC";
    return query($sql, [$publicationId]);
}

function countQualifiedApplicants($publicationId, $positionId)
{
    $sql = "SELECT COUNT(id) AS total 
            FROM vacancy_applications 
            WHERE publication_id = ? AND position_id = ? AND status = 'Qualified'";
    $result = find($sql, [$publicationId, $positionId]);
    return $result ? (int) $result['total'] : 0;
}

function countAssessedQualifiedApplicants($publicationId, $positionId)
{
    $sql = "SELECT COUNT(va.id) AS total 
            FROM vacancy_applications AS va
            INNER JOIN assessment_scores AS s ON va.id = s.application_id
            WHERE va.publication_id = ? AND va.position_id = ? AND va.status = 'Qualified' AND s.total_accumulated_score IS NOT NULL";
    $result = find($sql, [$publicationId, $positionId]);
    return $result ? (int) $result['total'] : 0;
}

function applicantsCountByPosition($publicationId)
{
    $sql = "SELECT p.id AS position_id, p.official_title AS name, COUNT(DISTINCT va.application_code_id) AS count
            FROM vacancy_applications AS va
            INNER JOIN positions AS p ON va.position_id = p.id
            WHERE va.publication_id = ?
            GROUP BY p.id, p.official_title
            ORDER BY count DESC, p.official_title ASC";
    return query($sql, [$publicationId]);
}

function applicantEmploymentStatusCount($publicationId)
{
    $sql = "SELECT 
                SUM(CASE WHEN e.id IS NOT NULL THEN 1 ELSE 0 END) AS `internal`,
                SUM(CASE WHEN e.id IS NULL THEN 1 ELSE 0 END) AS `external`
            FROM (
                SELECT DISTINCT application_code_id
                FROM vacancy_applications
                WHERE publication_id = ?
            ) AS unique_applicants
            LEFT JOIN employees AS e ON unique_applicants.application_code_id = e.id";
    return find($sql, [$publicationId]);
}

function applicantsListByPublication($publicationId, $positionId = null, $status = null)
{
    $params = [$publicationId];
    $filters = "";
    if ($positionId !== null && $positionId !== '' && $positionId !== 'all') {
        $filters .= " AND va.position_id = ? ";
        $params[] = $positionId;
    }
    if ($status === 'internal' || $status === 'employed') {
        $filters .= " AND e.id IS NOT NULL ";
    } elseif ($status === 'external' || $status === 'not_employed') {
        $filters .= " AND e.id IS NULL ";
    }
    $sql = "SELECT va.id, va.created_at, ac.code AS application_code, p.official_title, p.category AS position_group,
                   va.status, va.application_code_id,
                   IF(e.id IS NOT NULL, 1, 0) AS is_employed,
                   va.remarks, s.total_accumulated_score,
                   e.`religion_id`, e.`specify_other_religion`, e.`ethnic_group_id`, e.`specify_other_ethnic_group`
            FROM vacancy_applications AS va
            INNER JOIN application_codes AS ac ON va.application_code_id = ac.id
            INNER JOIN positions AS p ON va.position_id = p.id
            LEFT JOIN `employees` AS e ON ac.`id` = e.`id`
            LEFT JOIN `ethnic_groups` AS eg ON e.`ethnic_group_id` = eg.`id`
            LEFT JOIN `religion` AS r ON e.`religion_id` = r.`id`
            LEFT JOIN assessment_scores AS s ON va.id = s.application_id
            WHERE va.publication_id = ?
            {$filters}
            ORDER BY p.category ASC, p.official_title ASC, va.created_at DESC";

    return query($sql, $params);
}

function applicantDiversityGender()
{
    $sql = "SELECT a.`sex` AS `name`, 
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`, 
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`, 
                COUNT(*) AS `total`, COUNT(*) AS `count`
            FROM `applicants` a
            INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            WHERE e.`id` IS NULL
            GROUP BY a.`sex` 
            ORDER BY a.`sex` DESC";
    return query($sql);
}

function applicantDiversityGeneration()
{
    $sql = "SELECT 
                CASE 
                    WHEN YEAR(a.`birthdate`) BETWEEN 1946 AND 1964 THEN 'Baby Boomers (1946-1964)'
                    WHEN YEAR(a.`birthdate`) BETWEEN 1965 AND 1980 THEN 'Generation X (1965-1980)'
                    WHEN YEAR(a.`birthdate`) BETWEEN 1981 AND 1996 THEN 'Generation Y / Millennials (1981-1996)'
                    WHEN YEAR(a.`birthdate`) BETWEEN 1997 AND 2012 THEN 'Generation Z (1997-2012)'
                    WHEN YEAR(a.`birthdate`) >= 2013 THEN 'Generation Alpha (2013-Present)'
                    ELSE 'Silent Generation / Other'
                END AS `name`,
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`,
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(*) AS `total`,
                COUNT(*) AS `count`
            FROM `applicants` a
            INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            WHERE e.`id` IS NULL AND a.`birthdate` IS NOT NULL AND a.`birthdate` <> '0000-00-00'
            GROUP BY `name`
            ORDER BY MIN(a.`birthdate`) ASC";
    return query($sql);
}

function applicantDiversityReligion()
{
    $sql = "SELECT 
                COALESCE(NULLIF(TRIM(r.`name`), ''), NULLIF(TRIM(a.`specify_other_religion`), ''), 'Not Specified') AS `name`,
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`,
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(*) AS `total`,
                COUNT(*) AS `count`
            FROM `applicants` a
            INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            LEFT JOIN `religion` r ON a.`religion_id` = r.`id`
            WHERE e.`id` IS NULL
            GROUP BY `name`
            ORDER BY `total` DESC";
    return query($sql);
}


function applicantDiversityEthnic()
{
    $sql = "SELECT 
                COALESCE(NULLIF(TRIM(eg.`name`), ''), NULLIF(TRIM(a.`specify_other_ethnic_group`), ''), 'Not Specified') AS `name`, 
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`,
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(a.`id`) AS `total`,
                COUNT(a.`id`) AS `count`
            FROM `applicants` a
            INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            LEFT JOIN `ethnic_groups` eg ON a.`ethnic_group_id` = eg.`id`
            WHERE e.`id` IS NULL
            GROUP BY `name` 
            ORDER BY `total` DESC";
    return query($sql);
}

function applicantDiversityPwd()
{
    $sql = "SELECT 
                CASE 
                    WHEN a.`with_disability` = 1 THEN 'PWD' 
                    ELSE 'Non-PWD' 
                END AS `name`, 
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`,
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(a.`id`) AS `total`,
                COUNT(a.`id`) AS `count`
            FROM `applicants` a
            INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            WHERE e.`id` IS NULL
            GROUP BY `name` 
            ORDER BY `total` DESC";
    return query($sql);
}

function applicantDiversityUndergraduate()
{
    $sql = "SELECT 
                COALESCE(NULLIF(TRIM(a.`undergraduate`), ''), 'Not Specified') AS `name`,
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`,
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(a.`id`) AS `total`,
                COUNT(a.`id`) AS `count`
            FROM `applicants` a
            INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            WHERE e.`id` IS NULL
            GROUP BY `name`
            ORDER BY `total` DESC";
    return query($sql);
}

function applicantDiversityPostGraduate()
{
    $sql = "SELECT 
                COALESCE(NULLIF(TRIM(a.`graduate_studies`), ''), 'Not Specified') AS `name`,
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`,
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(a.`id`) AS `total`,
                COUNT(a.`id`) AS `count`
            FROM `applicants` a
            INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            WHERE e.`id` IS NULL
            GROUP BY `name`
            ORDER BY `total` DESC";
    return query($sql);
}

function applicantDiversityRegistration()
{
    $sql = "SELECT 
                CASE 
                    WHEN va.application_code_id IS NOT NULL THEN 'Applied to Vacancy' 
                    ELSE 'No Application Made' 
                END AS `name`,
                SUM(CASE WHEN a.`sex` = 'Male' THEN 1 ELSE 0 END) AS `male`,
                SUM(CASE WHEN a.`sex` = 'Female' THEN 1 ELSE 0 END) AS `female`,
                COUNT(*) AS `total`,
                COUNT(*) AS `count`
            FROM `applicants` a
            LEFT JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id
            LEFT JOIN `employees` e ON a.`id` = e.`id`
            WHERE e.`id` IS NULL
            GROUP BY `name`
            ORDER BY `total` DESC";
    return query($sql);
}

function applicantDiversityList($onlyApplied = false)
{
    $join = "";
    if ($onlyApplied) {
        $join = " INNER JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va ON a.`id` = va.application_code_id ";
    }
    $sql = "SELECT a.`id`, a.`last_name`, a.`first_name`, a.`middle_name`, a.`name_extension`, 
                a.`sex`, a.`birthdate`, a.`civil_status`,
                a.`religion_id`, a.`specify_other_religion`, a.`ethnic_group_id`, a.`specify_other_ethnic_group`,
                COALESCE(NULLIF(TRIM(r.`name`), ''), NULLIF(TRIM(a.`specify_other_religion`), ''), 'Not Specified') AS `religion`,
                COALESCE(NULLIF(TRIM(eg.`name`), ''), NULLIF(TRIM(a.`specify_other_ethnic_group`), ''), 'Not Specified') AS `ethnic_group`,
                a.`specify_other_ethnic_group` AS `ethnic_group_specify`,
                a.`email_address`, a.`mobile_number`, a.`with_disability`, a.`undergraduate`, a.`graduate_studies`,
                IF(va_status.application_code_id IS NOT NULL, 1, 0) AS `has_applied`
            FROM `applicants` AS a
            {$join}
            LEFT JOIN (SELECT DISTINCT application_code_id FROM vacancy_applications) va_status ON a.`id` = va_status.application_code_id
            LEFT JOIN `employees` AS e ON a.`id` = e.`id`
            LEFT JOIN `religion` AS r ON a.`religion_id` = r.`id`
            LEFT JOIN `ethnic_groups` AS eg ON a.`ethnic_group_id` = eg.`id`
            WHERE e.`id` IS NULL
            ORDER BY a.`last_name` ASC, a.`first_name` ASC";
    $results = query($sql);
    return is_array($results) ? $results : [];
}

function getApplicantDemographicGroup($row, $exportId)
{
    switch ($exportId) {
        case 'gender':
            return $row['sex'] ?? 'Not Specified';
        case 'generation':
            if (empty($row['birthdate']) || $row['birthdate'] === '0000-00-00') {
                return 'Silent Generation / Other';
            }
            $year = (int) date('Y', strtotime($row['birthdate']));
            if ($year >= 1946 && $year <= 1964)
                return 'Baby Boomers (1946-1964)';
            if ($year >= 1965 && $year <= 1980)
                return 'Generation X (1965-1980)';
            if ($year >= 1981 && $year <= 1996)
                return 'Generation Y / Millennials (1981-1996)';
            if ($year >= 1997 && $year <= 2012)
                return 'Generation Z (1997-2012)';
            if ($year >= 2013)
                return 'Generation Alpha (2013-Present)';
            return 'Silent Generation / Other';
        case 'religion':
            $religion = trim($row['religion'] ?? '');
            return $religion !== '' ? $religion : 'Not Specified';
        case 'ethnic':
            $ethnic = trim($row['ethnic_group'] ?? '');
            if ($ethnic === 'Others' && !empty($row['ethnic_group_specify'])) {
                return trim($row['ethnic_group_specify']);
            }
            return $ethnic !== '' ? $ethnic : 'Not Specified';
        case 'pwd':
            if (isset($row['with_disability']) && $row['with_disability'] == 1) {
                return 'PWD';
            }
            return 'Non-PWD';
        case 'undergraduate':
            $undergrad = trim($row['undergraduate'] ?? '');
            return $undergrad !== '' ? $undergrad : 'Not Specified';
        case 'postgraduate':
            $postgrad = trim($row['graduate_studies'] ?? '');
            return $postgrad !== '' ? $postgrad : 'Not Specified';
        case 'registration':
            return (isset($row['has_applied']) && $row['has_applied'] == 1) ? 'Applied to Vacancy' : 'No Application Made';
        default:
            return 'Other';
    }
}