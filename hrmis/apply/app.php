<?php

$appTitle = $page = 'Online Application Form';
$enableScripts = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_LENGTH'])) {
    $max_size_str = ini_get('post_max_size');
    $max_size_bytes = parseSizeToBytes($max_size_str);

    if ($_SERVER['CONTENT_LENGTH'] > $max_size_bytes) {
        $message = "The total upload size exceeds the limit of {$max_size_str}. Please reduce file sizes.";
        $showAlert = true;
        return;
    }
}

if (isset($_POST['submit-application'])) {
    $publicationId = sanitize(decipher($_POST['publication_id'] ?? null));
    $applicationCode = sanitize($_POST['applicant_id'] ?? '');
    $positions = $_POST['position_ids'] ?? null;
    $showAlert = true;

    if (!$publicationId) {
        $message = 'Invalid publication link.';
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
        $message = 'You have already applied for all selected positions of this publication.';
        return;
    }

    $uploadErrors = [];
    $savedFileName = null;
    $allowedMimeTypes = ['application/pdf'];
    $allowedExtensions = ['pdf'];
    $folder = sanitize($applicationCode);
    $uploadDir = root() . '/uploads/applications/' . $folder;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $inputName = 'application_file';
    if (isset($_FILES[$inputName]) && !empty($_FILES[$inputName]['name'])) {
        $file = $_FILES[$inputName];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors[] = 'Error uploading file.';
        } elseif ($file['size'] > FILE_UPLOAD_SIZE_LIMIT) {
            $uploadErrors[] = "File {$file['name']} exceeds the 25MB upload limit.";
        } else {
            $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                $uploadErrors[] = "File {$file['name']} must be a PDF.";
            } else {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $fileMimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if (!in_array($fileMimeType, $allowedMimeTypes)) {
                    $uploadErrors[] = "File {$file['name']} has an invalid MIME type.";
                }
            }
        }

        if (empty($uploadErrors)) {
            $timestamp = time();
            $newFilename = strtoupper("APPLICATION_{$timestamp}") . '.pdf';
            $filePath = "{$uploadDir}/{$newFilename}";

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $savedFileName = $newFilename;
            } else {
                $uploadErrors[] = "Failed to save {$file['name']}";
            }
        }
    } else {
        $uploadErrors[] = "Please upload your application document.";
    }

    if (!empty($uploadErrors)) {
        $message = 'Upload errors: ' . implode(' ', $uploadErrors);
        return;
    }

    try {
        beginTransaction();

        $appliedCount = 0;
        foreach ($selectedPositionIds as $posId) {
            if (createApplication($publicationId, $applicationId, $posId)) {
                $appliedCount++;
            } else {
                throw new Exception('Failed to create application record.');
            }
        }

        if ($appliedCount > 0) {
            if ($savedFileName) {
                $savedRequirement = saveVacancyApplicationRequirement($publicationId, $applicationId, "{$folder}/{$savedFileName}");

                if (!$savedRequirement) {
                    throw new Exception('Failed to save vacancy application requirement.');
                }
            }

            commit();

            $message = "Your application for {$appliedCount} position" . ($appliedCount > 1 ? 's ' : ' ') . "has been processed successfully. Check your registered email for your application details.";
            $success = true;
        } else {
            throw new Exception('No application record was registered.');
        }
    } catch (Exception $e) {
        rollBack();

        if ($savedFileName && file_exists("{uploadDir}/{$savedFileName}")) {
            unlink("{$uploadDir}/{$savedFileName}");
        }

        $message = 'An error occured while creating your application: ' . $e->getMessage();
    }
}