<?php

$appTitle = $page = 'Online Application Form';
$enableScripts = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && empty($_FILES)) {
    if (isset($_SERVER['CONTENT_LENGTH'])) {
        $max_size_str = ini_get('post_max_size');
        $max_size_bytes = parseSizeToBytes($max_size_str);

        if ((int) $_SERVER['CONTENT_LENGTH'] > $max_size_bytes) {
            $showAlert = true;
            $message = "The total upload payload size exceeds the server limit of {$max_size_str}. Please optimize or compress your files.";
            return;
        }
    }
}

if (isset($_POST['submit-application'])) {
    $publicationId = sanitize(decipher($_POST['publication_id'] ?? null));
    $applicationCode = sanitize($_POST['applicant_id'] ?? '');
    $positions = $_POST['position_ids'] ?? null;
    $showAlert = true;
    $stagedFile = null;

    try {
        if (!$publicationId) {
            throw new Exception('Invalid publication reference verification layer link.');
        }

        $applicationId = applicantId($applicationCode);
        if (!$applicationId) {
            throw new Exception('Invalid applicant ID structural assignment format values.');
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
            throw new Exception('You have already registered operational records targeting these vacancies.');
        }

        $safeFolder = preg_replace('/[^a-zA-Z0-9_\-]/', '', $applicationCode);

        if (!empty($_FILES['application-file']['tmp_name']) && is_uploaded_file($_FILES['application-file']['tmp_name'])) {
            $stagedFile = stageUploadedFile(
                $_FILES['application-file'],
                ['application/pdf' => 'pdf'],
                root() . "/uploads/applications/{$safeFolder}",
                "APPLICATION"
            );
        } else {
            throw new Exception("Please upload your mandatory application documents.");
        }

        if (!$stagedFile || !isset($stagedFile['secure_name']) || !isset($stagedFile['full_path'])) {
            throw new Exception("The application document could not be staged safely. Please try again.");
        }

        beginTransaction();

        $appliedCount = 0;
        foreach ($selectedPositionIds as $posId) {
            if (createApplication($publicationId, $applicationId, $posId)) {
                $appliedCount++;
            } else {
                throw new Exception('Failed to record vacancy target tracking indexes.');
            }
        }

        if ($appliedCount > 0) {
            $dbPath = "uploads/applications/{$safeFolder}/{$stagedFile['secure_name']}";

            if (!saveVacancyApplicationRequirement($publicationId, $applicationId, $dbPath)) {
                throw new Exception('Failed to save foundational system validation requirements.');
            }

            commitStagedFile($stagedFile);
            commit();

            $pluralSuffix = $appliedCount > 1 ? 's' : '';
            $verbConjugation = $appliedCount > 1 ? 'have' : 'has';

            $message = "Your application for {$appliedCount} position{$pluralSuffix} {$verbConjugation} been processed successfully.";
            $success = true;
            createSystemLog($stationId, $applicationId, "Submitted application for {$appliedCount} position(s)", $applicationId, clientIp());

        } else {
            throw new Exception('Zero relational applications processed across loop contexts.');
        }

    } catch (Exception $e) {
        rollBack();
        if ($stagedFile && file_exists($stagedFile['full_path'])) {
            unlink($stagedFile['full_path']);
        }
        $message = $e->getMessage();
    }
}