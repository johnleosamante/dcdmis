<?php

$appTitle = $page = 'Online Application Form';
$enableScripts = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST) && isset($_SERVER['CONTENT_LENGTH'])) {
    $max_size = ini_get('post_max_size');
    $message = "The total upload size exceeds the server limit of {$max_size}. Please reduce file sizes.";
    $showAlert = true;
    return;
}

if (isset($_POST['submit-application'])) {
    $publicationId = sanitize(decipher($_POST['publication_id'] ?? null));
    $applicationCode = sanitize($_POST['applicant_id'] ?? '');
    $positions = $_POST['position_ids'] ?? null;
    $showAlert = true;

    if (!$publicationId) {
        $message = 'Invalid publication link';
        return;
    }

    $applicationId = applicantId($applicationCode);
    if (!$applicationId) {
        $message = 'Invalid applicant ID. Please provide a valid 18-digit applicant ID.';
        return;
    }

    if (!$positions || !is_array($positions)) {
        $message = 'Please select at least one position you wish to apply for.';
        return;
    }

    $selectedPositionIds = [];
    foreach ($positions as $position) {
        $pId = sanitize(decipher($position));
        if ($pId) {
            if (!hasAlreadyApplied($publicationId, $applicationId, $pId)) {
                $selectedPositionIds[] = $pId;
            }
        }
    }

    if (empty($selectedPositionIds)) {
        $message = 'You have already applied for all selected positions or selection is invalid.';
        return;
    }

    $uploadErrors = [];
    $uploadedFiles = [];
    $allowedMimeTypes = ['application/pdf'];
    $allowedExtensions = ['pdf'];
    $folder = sanitize($applicationCode);
    $uploadDir = root() . '/uploads/applications/' . $folder;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    foreach ($_FILES as $fieldName => $file) {
        if (empty($file['name']) || $file['error'] === UPLOAD_ERR_NO_FILE)
            continue;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors[] = "Error uploading {$fieldName}.";
            continue;
        }
        if ($file['size'] > FILE_UPLOAD_SIZE_LIMIT) {
            $uploadErrors[] = "File {$file['name']} exceeds 20MB limit.";
            continue;
        }

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $uploadErrors[] = "File {$file['name']} must be a PDF.";
            continue;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileMimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            $uploadErrors[] = "File {$file['name']} has an invalid MIME type.";
            continue;
        }

        $timestamp = time();
        $randomString = bin2hex(random_bytes(4));
        $newFileName = strtoupper("{$fieldName}_{$timestamp}") . '.pdf';
        $filePath = "{$uploadDir}/{$newFileName}";

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $uploadedFiles[$fieldName] = $newFileName;
        } else {
            $uploadErrors[] = "Failed to save {$file['name']}.";
        }
    }

    if (!empty($uploadErrors)) {
        $message = 'Upload errors: ' . implode(' ', $uploadErrors);
        return;
    }

    $appliedCount = 0;
    foreach ($selectedPositionIds as $posId) {
        if (createApplication($publicationId, $applicationId, $posId)) {
            $appliedCount++;
        }
    }

    if ($appliedCount > 0) {
        foreach ($uploadedFiles as $fieldName => $savedName) {
            saveVacancyApplicationRequirement(
                $publicationId,
                $applicationId,
                "{$folder}/{$savedName}",
                basicDocumentRequirementId($fieldName)
            );
        }
        $message = "Your application for $appliedCount position(s) has been processed successfully. Check your registered email for your application details.";
        $success = true;
    } else {
        $message = 'An error occurred while creating your application.';
    }
}