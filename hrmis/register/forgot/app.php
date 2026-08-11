<?php
// hrmis/register/forgot/app.php
$appTitle = $page = 'Recover Applicant ID';
$userEmail = null;

if (isset($_POST['recover-applicant-id'])) {
    $showAlert = true;
    $success = false;
    $userEmail = sanitize($_POST['email']);

    if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        return;
    }

    $clientIdentifier = clientIp();
    if (!checkRateLimit($clientIdentifier, 3, 600)) {
        $message = 'Too many recovery attempts. Please try again later.';
        $success = true;
        return;
    }

    $message = "If an account is associated with this email, check your account inbox.";

    require_once(root() . '/includes/database/employee.php');
    require_once(root() . '/includes/database/position.php');
    require_once(root() . '/includes/database/vacancy.php');

    $isInternalEmployee = false;
    $applicantData = null;
    $applicantCode = null;

    $emp = find("SELECT e.*, ac.`code` AS `applicant_code` FROM `employees` e INNER JOIN `application_codes` ac ON e.`id` = ac.`id` WHERE e.`email_address` = ? LIMIT 1", [$userEmail]);
    if ($emp && !empty($emp['applicant_code'])) {
        $isInternalEmployee = true;
        $applicantData = $emp;
        $applicantCode = $emp['applicant_code'];
    } else {
        $app = find("SELECT a.*, ac.`code` AS `applicant_code` FROM `applicants` a INNER JOIN `application_codes` ac ON a.`id` = ac.`id` WHERE a.`email_address` = ? LIMIT 1", [$userEmail]);
        if ($app && !empty($app['applicant_code'])) {
            $isInternalEmployee = false;
            $applicantData = $app;
            $applicantCode = $app['applicant_code'];
        }
    }

    if (!$applicantData || !$applicantCode) {
        $success = true;
        error_log("Applicant ID recovery attempted for non-existent or unregistered email: {$userEmail}");
        return;
    }

    $applicantName = strtoupper(toName($applicantData['last_name'], $applicantData['first_name'], $applicantData['middle_name'], $applicantData['name_extension'], true));
    $title = strtoupper(strtolower($applicantData['sex'] ?? '') === 'male' ? 'Mr. ' : 'Ms. ');

    $applicantType = strtoupper($isInternalEmployee ? 'Current Division Employee' : 'New Applicant');
    $employeePosText = '';
    $updateNoticeText = "\nNote: If any of your information listed above is incorrect or not up to date, please approach the Schools Division Office Personnel Section for updating.\n";

    if ($isInternalEmployee) {
        require_once(root() . '/includes/database/school.php');
        $empPos = position($applicantData['id']);
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

    $lastNameText = strtoupper(!empty($applicantData['last_name']) ? $applicantData['last_name'] : 'N/A');
    $firstNameText = strtoupper(!empty($applicantData['first_name']) ? $applicantData['first_name'] : 'N/A');
    $middleNameText = strtoupper(!empty($applicantData['middle_name']) ? $applicantData['middle_name'] : 'N/A');
    $nameExtensionText = strtoupper(!empty($applicantData['name_extension']) ? $applicantData['name_extension'] : 'N/A');

    $sexText = strtoupper(!empty($applicantData['sex']) ? $applicantData['sex'] : 'N/A');

    $rawBirthdate = $applicantData['birthdate'] ?? $applicantData['birth_date'] ?? '';
    $birthdateText = strtoupper(($rawBirthdate && strtotime($rawBirthdate)) ? date('F j, Y', strtotime($rawBirthdate)) : ($rawBirthdate ?: 'N/A'));

    $civilStatusText = strtoupper(!empty($applicantData['civil_status']) ? $applicantData['civil_status'] : 'N/A');

    $religionText = 'N/A';
    if (!empty($applicantData['specify_other_religion'])) {
        $religionText = strtoupper($applicantData['specify_other_religion']);
    } elseif (!empty($applicantData['religion_id'])) {
        $rel = religion($applicantData['religion_id']);
        if ($rel && !empty($rel['name'])) {
            $religionText = strtoupper($rel['name']);
        }
    }

    $ethnicText = 'N/A';
    if (!empty($applicantData['specify_other_ethnic_group'])) {
        $ethnicText = strtoupper($applicantData['specify_other_ethnic_group']);
    } elseif (!empty($applicantData['ethnic_group_id'])) {
        $eg = find("SELECT `name` FROM `ethnic_groups` WHERE `id` = ? LIMIT 1", [$applicantData['ethnic_group_id']]);
        if ($eg && !empty($eg['name'])) {
            $ethnicText = strtoupper($eg['name']);
        }
    }

    $pwdText = (!empty($applicantData['with_disability']) || !empty($applicantData['is_pwd'])) ? 'YES' : 'NO';

    $emailText = strtolower($applicantData['email_address'] ?? $applicantData['email'] ?? $userEmail);
    $mobileText = strtoupper($applicantData['mobile_number'] ?? $applicantData['mobile'] ?? 'N/A');

    if ($isInternalEmployee) {
        require_once(root() . '/includes/database/education.php');
        require_once(root() . '/includes/database/eligibility.php');

        $addressParts = array_filter([
            $applicantData['residence_lot'] ?? null,
            $applicantData['residence_street'] ?? null,
            $applicantData['residence_subdivision'] ?? null,
            $applicantData['residence_barangay'] ?? null,
            $applicantData['residence_city'] ?? null,
            $applicantData['residence_province'] ?? null,
            $applicantData['residence_zip'] ?? null,
        ]);
        $addressText = !empty($addressParts) ? strtoupper(implode(', ', $addressParts)) : 'N/A';

        $empEducations = educationalBackgrounds($applicantData['id']);

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

        $empEligibilities = eligibilities($applicantData['id']);
        $eligList = [];
        foreach ($empEligibilities as $el) {
            if (!empty($el['title'])) {
                $eligList[] = trim($el['title']);
            }
        }
        $eligibilitiesText = !empty($eligList) ? strtoupper(implode(', ', array_unique($eligList))) : 'NONE';
    } else {
        $addressParts = array_filter([
            $applicantData['lot'] ?? null,
            $applicantData['street'] ?? null,
            $applicantData['subdivision'] ?? null,
            $applicantData['barangay'] ?? null,
            $applicantData['city'] ?? null,
            $applicantData['province'] ?? null,
            $applicantData['zip'] ?? null,
        ]);
        $addressText = !empty($addressParts) ? strtoupper(implode(', ', $addressParts)) : 'N/A';

        $educationText = strtoupper(!empty($applicantData['undergraduate']) ? $applicantData['undergraduate'] : ($applicantData['education'] ?? 'N/A'));
        $graduateStudiesText = strtoupper(!empty($applicantData['graduate_studies']) ? $applicantData['graduate_studies'] : 'NONE');

        $eligibilitiesList = [];
        if (!empty($applicantData['eligibilities'])) {
            if (is_array($applicantData['eligibilities'])) {
                $eligibilitiesList = $applicantData['eligibilities'];
            } elseif (is_string($applicantData['eligibilities'])) {
                $decoded = json_decode($applicantData['eligibilities'], true);
                if (is_array($decoded)) {
                    $eligibilitiesList = $decoded;
                }
            }
        }
        $eligibilitiesText = !empty($eligibilitiesList) ? strtoupper(implode(', ', $eligibilitiesList)) : 'NONE';
    }
    $callUrl = uri(DOMAIN) . '/hrmis/apply';

    $emailBody = <<<EOT
Hello, {$title}{$applicantName}!

As requested, here is your 18-digit Applicant ID:

Applicant ID: {$applicantCode}

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

    $targetDeliveryEmail = PRODUCTION_MODE ? $userEmail : DEVELOPER_EMAIL;
    $subject = "Applicant ID Recovery Request";

    if (!sendMail($targetDeliveryEmail, $subject, $emailBody)) {
        $success = false;
        $message = 'We encountered an error sending the applicant id recovery request email. Please try again later.';
        error_log("Failed to send reset request email to: {$userEmail} (Routed to: {$targetDeliveryEmail})");
        return;
    }

    createSystemLog(DIVISION_ID, null, 'Recovered Applicant ID via email', $applicantCode, clientIp());
    $success = true;
}