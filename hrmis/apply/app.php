<?php
// hrmis/apply/app.php
$appTitle = $page = 'Online Application';
$enableScripts = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES)) {
    if (isset($_SERVER['CONTENT_LENGTH'])) {
        $max_size_str = ini_get('post_max_size');
        $max_size_bytes = parseSizeToBytes($max_size_str);

        if ((int) $_SERVER['CONTENT_LENGTH'] > $max_size_bytes) {
            $showAlert = true;
            $message = "The total upload size exceeds the limit of {$max_size_str}B. Please optimize or compress your file.";
            return;
        }
    }
}

if (isset($_POST['submit-application'])) {
    $publicationId = sanitize(decipher($_POST['publication_id']));
    $applicationCode = sanitize($_POST['applicant_id']);
    $positions = $_POST['position_ids'] ?? null;
    $showAlert = true;
    $stagedFile = null;

    try {
        if (!$publicationId) {
            throw new Exception('Invalid call for application link.');
        }

        $pub = publication($publicationId);
        if (!$pub) {
            throw new Exception('Call for application not found.');
        }

        $today = date('Y-m-d');
        $closeDate = date('Y-m-d', strtotime($pub['close_date']));
        $openDate = date('Y-m-d', strtotime($pub['open_date']));
        $currentTime = time();
        $deadline5pm = strtotime($closeDate . ' 17:00:00');

        if ($pub['status'] !== 'open') {
            throw new Exception('This call for application is currently closed.');
        }
        if (strtotime($closeDate) < strtotime($today)) {
            throw new Exception('The application period for this call for application has ended.');
        }
        if ($today === $closeDate && $currentTime >= $deadline5pm) {
            throw new Exception('The application period for this call for application ended at 5:00 PM today. Submissions are no longer accepted.');
        }
        if (strtotime($openDate) > strtotime($today)) {
            throw new Exception('The application period for this call for application has not started yet.');
        }

        $applicationId = applicantId($applicationCode);

        if (!$applicationId) {
            throw new Exception('Invalid applicant ID. Please provide a valid 18-digit applicant ID.');
        }

        if (!$positions || !is_array($positions)) {
            throw new Exception('Please select at least one position you wish to apply for.');
        }

        $selectedPositionIds = [];

        foreach ($positions as $position) {
            $pId = sanitize(decipher($position));

            if ($pId && !hasAlreadyApplied($publicationId, $applicationId, $pId)) {
                $selectedPositionIds[] = $pId;
            }
        }

        if (empty($selectedPositionIds)) {
            throw new Exception('You have already applied for all selected positions of this call for application.');
        }

        $safeFolder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $applicationCode);

        if (isset($_FILES['application-file']) && $_FILES['application-file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $stagedFile = stageUploadedFile(
                $_FILES['application-file'],
                ['application/pdf' => 'pdf'],
                root() . "/uploads/applications/{$safeFolder}",
                'APPLICATION'
            );

            if (!$stagedFile || !isset($stagedFile['secure_name']) || !isset($stagedFile['full_path'])) {
                throw new Exception('The application document could not be uploaded. Please try again.');
            }
        }

        beginTransaction();

        $appliedCount = 0;

        foreach ($selectedPositionIds as $posId) {
            if (createApplication($publicationId, $applicationId, $posId) === false) {
                throw new Exception('Failed to create application record.');
            }
            $appliedCount++;
        }

        if ($appliedCount > 0) {
            if ($stagedFile) {
                $dbPath = "uploads/applications/{$safeFolder}/{$stagedFile['secure_name']}";

                if (saveVacancyApplicationRequirement($publicationId, $applicationId, $dbPath) === false) {
                    throw new Exception('Failed to save application requirement.');
                }
            }

            commit();

            if ($stagedFile) {
                commitStagedFile($stagedFile);
            }

            $success = true;
        } else {
            throw new Exception('No application record was registered.');
        }
    } catch (Exception $e) {
        rollBack();

        if ($stagedFile && file_exists($stagedFile['full_path'])) {
            unlink($stagedFile['full_path']);
        }

        $message = $e->getMessage();
    }

    if ($success) {
        $pluralSuffix = $appliedCount > 1 ? 's' : '';
        $verbConjugation = $appliedCount > 1 ? 'have' : 'has';
        $message = "Your application for {$appliedCount} position{$pluralSuffix} {$verbConjugation} been processed successfully. Please check your email for confirmation.";

        createSystemLog(DIVISION_ID, null, "Submitted application for {$appliedCount} position{$pluralSuffix}", $applicationCode, clientIp());

        $isInternalEmployee = false;
        $applicantData = employee($applicationId);
        if ($applicantData) {
            $isInternalEmployee = true;
        } else {
            $applicantData = applicant($applicationId);
        }

        if ($applicantData && !empty($applicantData['email_address'])) {
            $email = $applicantData['email_address'];
            $applicantName = strtoupper(toName($applicantData['last_name'], $applicantData['first_name'], $applicantData['middle_name'], $applicantData['name_extension'], true));
            $title = strtoupper(strtolower($applicantData['sex'] ?? '') === 'male' ? 'Mr. ' : 'Ms. ');

            $pub = $pub ?: publication($publicationId);
            $pubTitle = $pub ? $pub['title'] : 'Vacancy Call for Application';
            $pubCode = $pub ? $pub['code'] : '';

            $appliedPositionsList = [];
            foreach ($selectedPositionIds as $posId) {
                $pos = positions($posId);
                if ($pos) {
                    $appliedPositionsList[] = "- " . $pos['official_title'] . " (SG " . $pos['salary_grade'] . ")";
                }
            }
            $positionsText = implode("\n", $appliedPositionsList);

            $applicantType = strtoupper($isInternalEmployee ? 'Current Division Employee' : 'New Applicant');
            $employeePosText = '';
            $updateNoticeText = "\nNote: If any of your information listed above is incorrect or not up to date, please approach the Schools Division Office Personnel Section for updating.\n";

            if ($isInternalEmployee) {
                require_once(root() . '/includes/database/school.php');
                $empPos = position($applicationId);
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

            $emailText = strtolower($applicantData['email_address'] ?? $applicantData['email'] ?? $email);
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

Your application for the following position(s) under call for application {$pubCode} ({$pubTitle}) has been received successfully:

{$positionsText}

APPLICANT DETAILS:
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
Please retain your Applicant ID ({$applicationCode}) for reference and use for available call for applications.

Call for Applications:
{$callUrl}

Download the checklist of requirements from the link below:

https://drive.google.com/file/d/1-t8G_AMDZAVoME4e-i47ZDqXn1gOrLHO

If nothing happens when you click the link, copy the link above and paste to your browser search bar instead.

Thank you.

***** THIS IS A SYSTEM GENERATED EMAIL. PLEASE DO NOT REPLY. *****
EOT;

            $targetDeliveryEmail = PRODUCTION_MODE ? $email : DEVELOPER_EMAIL;
            $subject = "Application Submission Confirmation";

            if (!sendMail($targetDeliveryEmail, $subject, $emailBody)) {
                error_log("Failed to send application confirmation email to: {$email} (Routed to: {$targetDeliveryEmail})");
            }
        }
    }
}