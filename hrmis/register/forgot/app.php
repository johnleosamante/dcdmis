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

    $targetDeliveryEmail = PRODUCTION_MODE ? $userEmail : DEVELOPER_EMAIL;

    $applicantName = toName($applicantData['last_name'], $applicantData['first_name'], $applicantData['middle_name'], $applicantData['name_extension'], true);
    $title = strtolower($applicantData['sex'] ?? '') === 'male' ? 'Mr. ' : 'Ms. ';

    $applicantType = $isInternalEmployee ? 'Current Division Employee' : 'New Applicant';
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
                $employeePosText = "\nCurrent Position: " . ($posTitle ?: 'N/A') . "\nStation / School: " . ($stName ?: 'N/A');
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

    $lastNameText = !empty($applicantData['last_name']) ? $applicantData['last_name'] : 'N/A';
    $firstNameText = !empty($applicantData['first_name']) ? $applicantData['first_name'] : 'N/A';
    $middleNameText = !empty($applicantData['middle_name']) ? $applicantData['middle_name'] : 'N/A';
    $nameExtensionText = !empty($applicantData['name_extension']) ? $applicantData['name_extension'] : 'N/A';

    $sexText = !empty($applicantData['sex']) ? ucfirst($applicantData['sex']) : 'N/A';

    $rawBirthdate = $applicantData['birthdate'] ?? $applicantData['birth_date'] ?? '';
    $birthdateText = ($rawBirthdate && strtotime($rawBirthdate)) ? date('F j, Y', strtotime($rawBirthdate)) : ($rawBirthdate ?: 'N/A');

    $civilStatusText = !empty($applicantData['civil_status']) ? ucfirst($applicantData['civil_status']) : 'N/A';

    $religionText = 'N/A';
    if (!empty($applicantData['specify_other_religion'])) {
        $religionText = $applicantData['specify_other_religion'];
    } elseif (!empty($applicantData['religion_id'])) {
        $rel = religion($applicantData['religion_id']);
        if ($rel && !empty($rel['name'])) {
            $religionText = $rel['name'];
        }
    }

    $ethnicText = 'N/A';
    if (!empty($applicantData['specify_other_ethnic_group'])) {
        $ethnicText = $applicantData['specify_other_ethnic_group'];
    } elseif (!empty($applicantData['ethnic_group_id'])) {
        $eg = find("SELECT `name` FROM `ethnic_groups` WHERE `id` = ? LIMIT 1", [$applicantData['ethnic_group_id']]);
        if ($eg && !empty($eg['name'])) {
            $ethnicText = $eg['name'];
        }
    }

    $pwdText = (!empty($applicantData['with_disability']) || !empty($applicantData['is_pwd'])) ? 'Yes' : 'No';

    $emailText = $applicantData['email_address'] ?? $applicantData['email'] ?? $userEmail;
    $mobileText = $applicantData['mobile_number'] ?? $applicantData['mobile'] ?? 'N/A';

    $addressParts = array_filter([
        $applicantData['lot'] ?? null,
        $applicantData['street'] ?? null,
        $applicantData['subdivision'] ?? null,
        $applicantData['barangay'] ?? null,
        $applicantData['city'] ?? null,
        $applicantData['province'] ?? null,
        $applicantData['zip'] ?? null,
    ]);
    $addressText = !empty($addressParts) ? implode(', ', $addressParts) : 'N/A';

    $educationText = $applicantData['undergraduate'] ?? $applicantData['education'] ?? 'N/A';
    $graduateStudiesText = !empty($applicantData['graduate_studies']) ? $applicantData['graduate_studies'] : 'None';

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
    $eligibilitiesText = !empty($eligibilitiesList) ? implode(', ', $eligibilitiesList) : 'None';

    $subject = "Applicant ID Recovery";

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

Download the checklist of requirements from the link below:

https://drive.google.com/file/d/1-t8G_AMDZAVoME4e-i47ZDqXn1gOrLHO

If nothing happens when you click the link, copy the link above and paste to your browser search bar instead.

Thank you.

***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****
EOT;

    if (!sendMail($targetDeliveryEmail, $subject, $emailBody)) {
        $success = false;
        $message = 'We encountered an error sending the applicant id recovery request email. Please try again later.';
        error_log("Failed to send reset request email to: {$userEmail} (Routed to: {$targetDeliveryEmail})");
        return;
    }

    createSystemLog(DIVISION_ID, null, 'Recovered Applicant ID via email', $applicantCode, clientIp());
    $success = true;
}