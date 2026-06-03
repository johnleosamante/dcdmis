<?php
// pis/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = HOME;
$page = $appTitle = 'Personnel Information System';

if (!isset($userId)) {
    redirect("$baseUri/login");
}

if (isset($_POST['primary-search-button'])) {
    redirect(customUri('pis', 'Search', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['update-identification'])) {
    $card = sanitize($_POST['card-type']);
    $number = sanitize($_POST['card-number']);
    $place = sanitize($_POST['card-place']);
    $date = sanitize($_POST['card-date']);
    $showAlert = true;
    $result = !employeeIdentification($userId) ?
        createIdentification($card, $number, $place, $date, $userId) :
        updateIdentification($card, $number, $place, $date, $userId);

    if ($result === false) {
        $success = false;
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }

    $success = true;
    $message = $result === 0 ?
        'No changes have been made to government issued ID.' :
        'Government issued ID has been updated successfully.';

    createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
}

if (isset($_POST['save-payslip'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $payslipId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $description = sanitize($_POST['description']);
    $oldFilename = sanitize(decipher($_POST['file-verifier'] ?? null));
    $showAlert = true;
    $stagedFile = null;

    try {
        if (empty($employeeId)) {
            throw new Exception('Invalid or expired transaction verifier token context.');
        }

        if (!empty($_FILES['file-upload']['tmp_name']) && is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
            $stagedFile = stageUploadedFile(
                $_FILES['file-upload'],
                ['application/pdf' => 'pdf'],
                root() . "/uploads/201_files/{$employeeId}",
                "PAYSLIP_{$employeeId}"
            );
        }

        beginTransaction();

        $newFilename = $stagedFile ? "uploads/201_files/{$employeeId}/{$stagedFile['secure_name']}" : $oldFilename;

        if (empty($newFilename)) {
            throw new Exception('No target asset references specified for creation parameters.');
        }

        $ext = pathinfo($newFilename, PATHINFO_EXTENSION);
        $hasExistingRecord = fileAttachment($employeeId, $payslipId);

        if (!$hasExistingRecord) {
            $result = createFileAttachment(20, $description, $newFilename, $ext, $employeeId);
            $logMessage = 'Added payslip.';
        } else {
            $result = updateFileAttachment(20, $description, $newFilename, $ext, $employeeId, $payslipId);
            $logMessage = 'Updated payslip.';
        }

        if ($result === false) {
            throw new Exception('Database transaction subsystem mutation failure.');
        }

        if ($stagedFile) {
            commitStagedFile($stagedFile);
        }

        commit();
        $success = true;
        $actionText = $hasExistingRecord ? 'updated' : 'added';
        $message = "Payslip has been {$actionText} successfully.";

        createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());

        if ($stagedFile && !empty($oldFilename) && file_exists(root() . "/{$oldFilename}")) {
            unlink(root() . "/{$oldFilename}");
        }
    } catch (Exception $e) {
        rollBack();
        if ($stagedFile && file_exists($stagedFile['full_path'])) {
            unlink($stagedFile['full_path']);
        }
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['delete-payslip'])) {
    $employeeId = sanitize(decipher($_POST['verifier'] ?? null));
    $payslipId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $success = false;
    $file = fileAttachment($employeeId, $payslipId);

    if (!$file) {
        $message = 'The requested payslip or file could not be found.';
        return;
    }

    $filename = $file['file_name'];
    $filePath = root() . "/{$filename}";

    if (file_exists($filePath)) {
        if (!unlink($filePath)) {
            $message = 'We encountered an error deleting the physical file. Please try again.';
            return;
        }
    }

    $result = deleteFileAttachment($employeeId, $payslipId);

    if ($result === false) {
        $message = 'We encountered an error updating the database. Please try again later.';
        return;
    }

    if ($result === 0) {
        $message = 'No changes have been made to the payslip database record.';
        return;
    }

    $success = true;
    $message = 'Payslip has been deleted successfully.';

    createSystemLog($stationId, $userId, 'Deleted employee payslip', $employeeId, clientIp());
}