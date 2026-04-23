<?php
// hrmis/register/app.php
require_once '../../includes/function.php';
require_once root() . '/includes/database/database.php';
require_once root() . '/includes/database/applicant.php';
require_once root() . '/includes/database/employee.php';
require_once root() . '/includes/email.php';
require_once root() . '/includes/string.php';

$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];
$success = $_SESSION['success'] ?? false;
$applicant_code = $_SESSION['applicant_code'] ?? null;
$applicant_email = $_SESSION['applicant_email'] ?? null;
$successfulRegistration = $success && $applicant_code && $applicant_email;

if ($successfulRegistration) {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');

    unset($_SESSION['errors'], $_SESSION['form_data'], $_SESSION['success'], $_SESSION['applicant_email'], $_SESSION['applicant_code']);
}

$page = $appTitle = 'Applicant Registration';

$required_fields = [
    'last_name' => 'Last Name',
    'first_name' => 'First Name',
    'barangay' => 'Barangay',
    'city' => 'City/Municipality',
    'province' => 'Province',
    'zip' => 'Zip Code',
    'birth_date' => 'Birth Date',
    'sex' => 'Sex at birth',
    'civil_status' => 'Civil Status',
    'religion' => 'Religion',
    'email' => 'Email Address',
    'mobile' => 'Mobile Number',
    'education' => 'Education'
];

if (isset($_POST['register-applicant'])) {
    $errors = [];
    $form_data = $_POST;
    $is_current_employee = !empty($_POST['is_current_employee']);

    $email = $is_current_employee ? sanitize($_POST['employee_email'] ?? null) : sanitize($_POST['email'] ?? null);

    if (empty($email)) {
        $errors[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }

    if (empty($errors)) {
        if ($is_current_employee) {
            $employee_id = findEmployeeByEmail($email);

            if (!$employee_id) {
                $errors[] = 'Email not registered as a current employee. Verify or register as a new applicant.';
            } elseif (applicantCode($employee_id)) {
                $errors[] = 'You have already registered as an applicant with this email.';
            }
        } else {
            foreach ($required_fields as $field => $label) {
                if (empty(trim($_POST[$field] ?? ''))) {
                    $errors[] = "$label is required.";
                }
            }

            $eligibility_keys = ['csc_professional', 'csc_sub_professional', 'let_pbet_lept', 'honor_graduate', 'barangay_official', 'other_eligibility'];
            $has_eligibility = array_filter(array_intersect_key($_POST, array_flip($eligibility_keys)));

            if (!$has_eligibility) {
                $errors[] = 'At least one eligibility must be selected.';
            }

            if (applicantEmailExists($email)) {
                $errors[] = 'Email address is already registered.';
            }

            $mobile = sanitize($_POST['mobile'] ?? null);

            if (strlen($mobile) < 10) {
                $errors[] = "Please provide a valid mobile number.";
            }

            if (applicantMobileExists($mobile)) {
                $errors[] = 'Mobile number is already registered.';
            }

            $birthdate = $_POST['birth_date'] ?? '';

            if ($birthdate && $date = date_create($birthdate)) {
                if (date_diff($date, date_create('today'))->y < 18) {
                    $errors[] = 'You must be at least 18 years old.';
                }
            } else {
                $errors[] = 'Please provide a valid birth date.';
            }
        }
    }

    if (empty($errors)) {
        beginTransaction();

        try {
            if ($is_current_employee) {
                $employee = employee($employee_id);
                $applicant_code = generateID();

                $data = [
                    'id' => $employee['id'],
                    'code' => $applicant_code,
                    'last_name' => $employee['last_name'],
                    'first_name' => $employee['first_name'],
                    'middle_name' => $employee['middle_name'],
                    'name_extension' => $employee['name_extension'],
                    'sex' => $employee['sex'],
                ];
            } else {
                $applicant_data = prepareApplicantData($_POST);

                if (!createApplicant($applicant_data)) {
                    throw new Exception('Insert failed');
                }

                $data = [
                    'id' => $applicant_data['id'],
                    'code' => $applicant_data['id'],
                    'last_name' => $_POST['last_name'],
                    'first_name' => $_POST['first_name'],
                    'middle_name' => $_POST['middle_name'],
                    'name_extension' => $_POST['name_extension'],
                    'sex' => $_POST['sex'],
                ];
            }

            createApplicantCode($data['id'], $data['code']);
            createSystemLog('143', null, 'Applicant registration', $data['id'], clientIp());
            commit();

            $applicant_code = $data['code'];
            $applicant_name = toName($data['last_name'], $data['first_name'], $data['middle_name'], $data['name_extension']);
            $title = strtolower($data['sex']) === 'male' ? 'Mr. ' : 'Ms. ';

            $_SESSION['success'] = true;
            $_SESSION['applicant_code'] = $applicant_code;
            $_SESSION['applicant_email'] = $email;

            $emailBody = "Good day, $title $applicant_name!\n\n
                        Your applicant registration was successful!\n\n
                        Applicant ID: $applicant_code \n\n
                        Please take note of your 18-digit applicant ID for reference and use for applications of available vacancies.\n\n\n
                        If you did not perform this action please contact us for assistance. Thank you.";

            redirect($_SERVER['REQUEST_URI']);
        } catch (Exception $e) {
            rollBack();
            error_log('Registration error: ' . $e->getMessage());
            $errors[] = 'An unexpected error occurred. Please try again later.';
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $form_data;
}