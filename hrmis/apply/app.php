<?php
// hrmis/apply/app.php
$appTitle = $page = 'Online Application Form';
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

        $applicantData = employee($applicationId);
        if (!$applicantData) {
            $applicantData = applicant($applicationId);
        }

        if ($applicantData && !empty($applicantData['email_address'])) {
            $email = $applicantData['email_address'];
            $applicantName = toName($applicantData['last_name'], $applicantData['first_name'], $applicantData['middle_name'], $applicantData['name_extension'], true);
            $title = strtolower($applicantData['sex'] ?? '') === 'Male' ? 'Mr. ' : 'Ms. ';

            $pub = publication($publicationId);
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

            $emailBody = <<<EOT
Hello, {$title} {$applicantName}!

Your application for the following position(s) under call for application {$pubCode} ({$pubTitle}) has been received successfully:

{$positionsText}

Please retain your Applicant ID ({$applicationCode}) for reference and download the checklist of requirements from the link below:

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