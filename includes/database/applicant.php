<?php
// includes/database/applicant.php
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

function updateApplicant($applicant_code, array $data)
{
    return update('applicants', $data, '`id` = ?', [$applicant_code]);
}

function deleteApplicant($applicant_code)
{
    return delete('applicants', '`id` = ?', [$applicant_code]);
}

function applicant($applicant_code)
{
    return find("SELECT * FROM `applicants` WHERE `id` = ? LIMIT 1", [$applicant_code]);
}

function applicants($limit = 50, $offset = 0)
{
    return query("SELECT * FROM `applicants` ORDER BY `applied_at` DESC LIMIT ? OFFSET ?", [$limit, $offset]);
}

function applicantCodeExists($applicant_code)
{
    return !empty(find("SELECT `id` FROM `applicants` WHERE `id` = ?", [$applicant_code]));
}

function countApplicants()
{
    $sql = "SELECT COUNT(*) as total FROM `applicants`";
    $result = find($sql);
    return (int) ($result['total'] ?? 0);
}

function applicantsByDateRange($start_date, $end_date)
{
    $sql = "SELECT * FROM `applicants` WHERE DATE(`applied_at`) BETWEEN ? AND ? ORDER BY `applied_at` DESC";
    return query($sql, [$start_date, $end_date]);
}

function searchApplicants($search_term)
{
    $term = "%{$search_term}%";
    $sql = "SELECT * FROM `applicants` 
            WHERE `first_name` LIKE ? 
            OR `last_name` LIKE ? 
            OR `middle_name` LIKE ? 
            OR `email_address` LIKE ? 
            ORDER BY `applied_at` DESC";
    return query($sql, [$term, $term, $term, $term]);
}