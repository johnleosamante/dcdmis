<?php
// hrmis/register/app.php
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
    'religion_id' => 'Religion',
    'email' => 'Email Address',
    'mobile' => 'Mobile Number',
    'education' => 'Education'
];

if (isset($_POST['register-applicant'])) {
    $errors = [];
    $form_data = $_POST;
    $is_current_employee = !empty($_POST['is_current_employee']);
    $employee_id = null;

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
            $employee_id = findEmployeeByEmail($email);

            if ($employee_id) {
                if (applicantCode($employee_id)) {
                    $errors[] = 'You have already registered as an applicant with this email.';
                }
            } else {
                foreach ($required_fields as $field => $label) {
                    if ($field === 'religion_id') {
                        $religion_val = trim($_POST['religion_id'] ?? '');
                        if (empty($religion_val)) {
                            $errors[] = "Religion is required.";
                        } elseif ($religion_val === 'Others' && empty(trim($_POST['specify_other_religion'] ?? ''))) {
                            $errors[] = "Please specify your religion.";
                        }
                    } else {
                        if (empty(trim($_POST[$field] ?? ''))) {
                            $errors[] = "$label is required.";
                        }
                    }
                }

                $eligibility_keys = ['csc_professional', 'csc_sub_professional', 'let_pbet_lept', 'honor_graduate', 'barangay_official', 'other_eligibility'];
                $has_eligibility = array_filter(array_intersect_key($_POST, array_flip($eligibility_keys)));

                if (!$has_eligibility) {
                    $errors[] = 'At least one eligibility must be selected.';
                } elseif (!empty($_POST['other_eligibility']) && empty(trim($_POST['other_eligibility_specify'] ?? ''))) {
                    $errors[] = 'Please specify your other eligibility.';
                }

                if (applicantEmailExists($email)) {
                    $errors[] = 'Email address is already registered.';
                }

                $mobile = sanitize($_POST['mobile'] ?? null);

                if (strlen($mobile ?? '') < 10) {
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
    }

    if (empty($errors)) {
        beginTransaction();
        $isRegistered = false;

        $registrationDetails = [];

        try {
            if (!empty($employee_id)) {
                $employee = employee($employee_id);

                if (!$employee) {
                    throw new Exception('Employee record not found.');
                }

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
                $registrationDetails = $employee;
            } else {
                $applicant_data = prepareApplicantData($_POST);

                if (createApplicant($applicant_data) === false) {
                    throw new Exception('Insert failed');
                }

                $data = [
                    'id' => $applicant_data['id'],
                    'code' => $applicant_data['id'],
                    'last_name' => $applicant_data['last_name'] ?? '',
                    'first_name' => $applicant_data['first_name'] ?? '',
                    'middle_name' => $applicant_data['middle_name'] ?? null,
                    'name_extension' => $applicant_data['name_extension'] ?? null,
                    'sex' => $applicant_data['sex'] ?? '',
                ];
                $registrationDetails = $applicant_data;
            }

            if (createApplicantCode($data['id'], $data['code']) === false) {
                throw new Exception('Failed to create applicant code.');
            }
            createSystemLog(DIVISION_ID, null, 'Applicant registration', $data['id'], clientIp());
            commit();
            $isRegistered = true;
        } catch (Exception $e) {
            rollBack();
            error_log('Registration error: ' . $e->getMessage());
            $errors[] = 'An unexpected error occurred. Please try again later.';
        }

        if ($isRegistered) {
            $applicant_code = $data['code'];
            $applicant_name = strtoupper(toName($data['last_name'], $data['first_name'], $data['middle_name'], $data['name_extension'], true));
            $title = strtoupper(strtolower($data['sex'] ?? '') === 'male' ? 'Mr. ' : 'Ms. ');

            $_SESSION['success'] = true;
            $_SESSION['applicant_code'] = $applicant_code;
            $_SESSION['applicant_email'] = $email;

            $isInternalEmployee = !empty($employee_id);
            $applicantType = strtoupper($isInternalEmployee ? 'Current Division Employee' : 'New Applicant');
            $employeePosText = '';
            $updateNoticeText = "\nNote: If any of your information listed above is incorrect or not up to date, please approach the Schools Division Office Personnel Section for updating.\n";

            if ($isInternalEmployee) {
                require_once(root() . '/includes/database/position.php');
                require_once(root() . '/includes/database/school.php');
                $empPos = position($employee_id);
                $isDivisionBased = false;

                if ($empPos) {
                    $posTitle = $empPos['official_title'] ?? '';
                    $stName = $empPos['station'] ?? '';
                    if ($posTitle || $stName) {
                        $employeePosText = "\nCurrent Position: " . strtoupper($posTitle ?: 'N/A') . "\nStation / School: " . strtoupper($stName ?: 'N/A');
                    }

                    $stId = (string) ($empPos['station_id'] ?? '');
                    if ($stId === '143' || strtoupper($stId) === 'SDO') {
                        $isDivisionBased = true;
                    } else if (!empty($stId)) {
                        $stSchool = schoolById($stId);
                        if ($stSchool && (($stSchool['alias'] ?? '') === 'SDO' || ($stSchool['district_id'] ?? '') === 'SDO' || strtolower($stSchool['category'] ?? '') === 'office')) {
                            $isDivisionBased = true;
                        }
                    }
                } else {
                    $isDivisionBased = true;
                }

                if (!$isDivisionBased) {
                    $updateNoticeText = "\nNote: If any of your information listed above is incorrect or not up to date, please approach your School Administrative Officer II or the Schools Division Office Personnel Section for updating.\n";
                }
            }

            $lastNameText = strtoupper(!empty($registrationDetails['last_name']) ? $registrationDetails['last_name'] : ($data['last_name'] ?? 'N/A'));
            $firstNameText = strtoupper(!empty($registrationDetails['first_name']) ? $registrationDetails['first_name'] : ($data['first_name'] ?? 'N/A'));
            $middleNameText = strtoupper(!empty($registrationDetails['middle_name']) ? $registrationDetails['middle_name'] : 'N/A');
            $nameExtensionText = strtoupper(!empty($registrationDetails['name_extension']) ? $registrationDetails['name_extension'] : 'N/A');

            $sexText = strtoupper(!empty($registrationDetails['sex']) ? $registrationDetails['sex'] : 'N/A');

            $rawBirthdate = $registrationDetails['birthdate'] ?? $registrationDetails['birth_date'] ?? '';
            $birthdateText = strtoupper(($rawBirthdate && strtotime($rawBirthdate)) ? date('F j, Y', strtotime($rawBirthdate)) : ($rawBirthdate ?: 'N/A'));

            $civilStatusText = strtoupper(!empty($registrationDetails['civil_status']) ? $registrationDetails['civil_status'] : 'N/A');

            $religionText = 'N/A';
            if (!empty($registrationDetails['specify_other_religion'])) {
                $religionText = strtoupper($registrationDetails['specify_other_religion']);
            } elseif (!empty($registrationDetails['religion_id'])) {
                $rel = religion($registrationDetails['religion_id']);
                if ($rel && !empty($rel['name'])) {
                    $religionText = strtoupper($rel['name']);
                }
            }

            $ethnicText = 'N/A';
            if (!empty($registrationDetails['specify_other_ethnic_group'])) {
                $ethnicText = strtoupper($registrationDetails['specify_other_ethnic_group']);
            } elseif (!empty($registrationDetails['ethnic_group_id'])) {
                $eg = find("SELECT `name` FROM `ethnic_groups` WHERE `id` = ? LIMIT 1", [$registrationDetails['ethnic_group_id']]);
                if ($eg && !empty($eg['name'])) {
                    $ethnicText = strtoupper($eg['name']);
                }
            }

            $pwdText = (!empty($registrationDetails['with_disability']) || !empty($registrationDetails['is_pwd'])) ? 'YES' : 'NO';

            $emailText = strtolower($registrationDetails['email_address'] ?? $registrationDetails['email'] ?? $email);
            $mobileText = strtoupper($registrationDetails['mobile_number'] ?? $registrationDetails['mobile'] ?? 'N/A');

            if ($isInternalEmployee) {
                require_once(root() . '/includes/database/education.php');
                require_once(root() . '/includes/database/eligibility.php');

                $addressParts = array_filter([
                    $registrationDetails['residence_lot'] ?? null,
                    $registrationDetails['residence_street'] ?? null,
                    $registrationDetails['residence_subdivision'] ?? null,
                    $registrationDetails['residence_barangay'] ?? null,
                    $registrationDetails['residence_city'] ?? null,
                    $registrationDetails['residence_province'] ?? null,
                    $registrationDetails['residence_zip'] ?? null,
                ]);
                $addressText = !empty($addressParts) ? strtoupper(implode(', ', $addressParts)) : 'N/A';

                $empEducations = educationalBackgrounds($employee_id);

                $collegeDegrees = [];
                $gradStudiesList = [];

                foreach ($empEducations as $ed) {
                    $level = strtolower(trim($ed['level'] ?? ''));
                    $highest = strtoupper(trim($ed['highest_level'] ?? ''));
                    $isGraduated = ($highest === 'GRADUATED') || (!empty($ed['year_graduated']) && $ed['year_graduated'] != 0);

                    if ($level === 'college' && $isGraduated) {
                        $degreeName = !empty($ed['course']) ? trim($ed['course']) : trim($ed['school'] ?? '');
                        if (!empty($degreeName)) {
                            $collegeDegrees[] = $degreeName;
                        }
                    } elseif ($level === 'graduate studies') {
                        $gradStudiesList[] = $ed;
                    }
                }

                $educationText = !empty($collegeDegrees) ? strtoupper(implode(', ', array_unique($collegeDegrees))) : 'N/A';

                if (!empty($gradStudiesList)) {
                    usort($gradStudiesList, function ($a, $b) {
                        $toA = (int) ($a['to_year'] ?? 0);
                        $toB = (int) ($b['to_year'] ?? 0);
                        if ($toA !== $toB) {
                            return $toB <=> $toA;
                        }
                        $fromA = (int) ($a['from_year'] ?? 0);
                        $fromB = (int) ($b['from_year'] ?? 0);
                        if ($fromA !== $fromB) {
                            return $fromB <=> $fromA;
                        }
                        return (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0);
                    });
                    $recentGrad = $gradStudiesList[0];
                    $gradCourse = !empty($recentGrad['course']) ? trim($recentGrad['course']) : trim($recentGrad['school'] ?? '');
                    $graduateStudiesText = !empty($gradCourse) ? strtoupper($gradCourse) : 'NONE';
                } else {
                    $graduateStudiesText = 'NONE';
                }

                $empEligibilities = eligibilities($employee_id);
                $eligList = [];
                foreach ($empEligibilities as $el) {
                    if (!empty($el['title'])) {
                        $eligList[] = trim($el['title']);
                    }
                }
                $eligibilitiesText = !empty($eligList) ? strtoupper(implode(', ', array_unique($eligList))) : 'NONE';
            } else {
                $addressParts = array_filter([
                    $registrationDetails['lot'] ?? null,
                    $registrationDetails['street'] ?? null,
                    $registrationDetails['subdivision'] ?? null,
                    $registrationDetails['barangay'] ?? null,
                    $registrationDetails['city'] ?? null,
                    $registrationDetails['province'] ?? null,
                    $registrationDetails['zip'] ?? null,
                ]);
                $addressText = !empty($addressParts) ? strtoupper(implode(', ', $addressParts)) : 'N/A';

                $educationText = strtoupper(!empty($registrationDetails['undergraduate']) ? $registrationDetails['undergraduate'] : ($registrationDetails['education'] ?? 'N/A'));
                $graduateStudiesText = strtoupper(!empty($registrationDetails['graduate_studies']) ? $registrationDetails['graduate_studies'] : 'NONE');

                $eligibilitiesList = [];
                if (!empty($registrationDetails['eligibilities'])) {
                    if (is_array($registrationDetails['eligibilities'])) {
                        $eligibilitiesList = $registrationDetails['eligibilities'];
                    } elseif (is_string($registrationDetails['eligibilities'])) {
                        $decoded = json_decode($registrationDetails['eligibilities'], true);
                        if (is_array($decoded)) {
                            $eligibilitiesList = $decoded;
                        }
                    }
                }
                $eligibilitiesText = !empty($eligibilitiesList) ? strtoupper(implode(', ', $eligibilitiesList)) : 'NONE';
            }
            $callUrl = uri(DOMAIN) . '/hrmis/apply';

            $emailBody = <<<EOT
Hello, {$title}{$applicant_name}!

Your applicant registration was successful.

Applicant ID: {$applicant_code}

REGISTRATION DETAILS:
----------------------------------------
Applicant Type: {$applicantType}{$employeePosText}

Personal Details:
Last Name: {$lastNameText}
First Name: {$firstNameText}
Middle Name: {$middleNameText}
Name Extension: {$nameExtensionText}
Sex: {$sexText}
Birth Date: {$birthdateText}
Civil Status: {$civilStatusText}
Religion: {$religionText}
Ethnic Group: {$ethnicText}
Person with Disability (PWD): {$pwdText}

Contact & Address:
Email Address: {$emailText}
Mobile Number: {$mobileText}
Address: {$addressText}

Education & Eligibilities:
Education: {$educationText}
Graduate Studies: {$graduateStudiesText}
Eligibilities: {$eligibilitiesText}
----------------------------------------
{$updateNoticeText}
Please retain your 18-digit applicant ID for reference and use for available call for applications.

Call for Applications:
{$callUrl}

Download the checklist of requirements from the link below:

https://drive.google.com/file/d/1-t8G_AMDZAVoME4e-i47ZDqXn1gOrLHO

If nothing happens when you click the link, copy the link above and paste to your browser search bar instead.

Thank you.

***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****
EOT;

            $targetDeliveryEmail = PRODUCTION_MODE ? $email : DEVELOPER_EMAIL;
            $subject = "Applicant Registration Confirmation";

            if (!sendMail($targetDeliveryEmail, $subject, $emailBody)) {
                error_log("Failed to send registration success email to: {$email} (Routed to: {$targetDeliveryEmail})");
            }

            redirect($_SERVER['REQUEST_URI']);
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $form_data;
}