<?php
// pis/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = HOME;
$page = $appTitle = 'Personnel Information System';

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
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


    if ($result === 0) {
        $message = 'No changes have been made to government issued ID.';
    } else {
        $message = 'Government issued ID has been updated successfully.';
        $success = true;

        createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
    }
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
            throw new Exception('Invalid or expired transaction.');
        }

        if (!empty($_FILES['file-upload']['tmp_name']) && is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
            $stagedFile = stageUploadedFile(
                $_FILES['file-upload'],
                ['application/pdf' => 'pdf'],
                root() . "/uploads/201_files/{$employeeId}",
                "PAYSLIP"
            );
        }

        beginTransaction();

        $newFilename = $stagedFile ? "uploads/201_files/{$employeeId}/{$stagedFile['secure_name']}" : $oldFilename;

        if (empty($newFilename)) {
            throw new Exception('No changes have been made to payslips.');
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
            throw new Exception('We encountered an error on our end. Please try again later.');
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
        $message = 'The requested payslip file does not exist.';
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

if (isset($_POST['submit-transfer-request'])) {
    $targetStationId = sanitize($_POST['target-station']);
    $reason = sanitize($_POST['reason']);
    $showAlert = true;
    $success = false;
    $stagedFile = null;

    try {
        if (empty($targetStationId)) {
            throw new Exception('Please select a preferred station assignment.');
        }
        if (empty($reason)) {
            throw new Exception('Please state your reason for the transfer request.');
        }
        if (empty($_FILES['attachment']['tmp_name']) || !is_uploaded_file($_FILES['attachment']['tmp_name'])) {
            throw new Exception('Please upload a supporting document.');
        }

        $currStation = station($userId);
        $currentStationId = $currStation ? $currStation['station_id'] : '';

        if (empty($currentStationId)) {
            throw new Exception('Your current station assignment could not be resolved. Please contact HR.');
        }

        if ($currentStationId === $targetStationId) {
            throw new Exception('Your target station must be different from your current station.');
        }

        $isTeaching = false;
        if ($currStation) {
            $pos = positions($currStation['position_id']);
            if ($pos && $pos['category'] === 'Teaching') {
                $isTeaching = true;
            }
        }

        $specialization = null;
        if ($isTeaching) {
            $specialization = sanitize($_POST['specialization'] ?? '');
            if (empty($specialization)) {
                throw new Exception('Please fill up your major subject / area of specialization.');
            }
        }

        // Stage the uploaded file
        $stagedFile = stageUploadedFile(
            $_FILES['attachment'],
            [
                'application/pdf' => 'pdf',
            ],
            root() . "/uploads/transfer_requests/{$userId}",
            "TRANSFER"
        );

        beginTransaction();

        $attachmentPath = "uploads/transfer_requests/{$userId}/" . $stagedFile['secure_name'];
        $result = createTransferRequest($userId, $currentStationId, $targetStationId, $reason, $attachmentPath, $specialization);

        if ($result === false) {
            throw new Exception('We encountered an error saving your request. Please try again later.');
        }

        commitStagedFile($stagedFile);
        commit();

        $success = true;
        $message = 'Your transfer request has been submitted successfully.';
        createSystemLog($stationId, $userId, 'Submitted transfer request', $userId, clientIp());

    } catch (Exception $e) {
        rollBack();
        if ($stagedFile && file_exists($stagedFile['full_path'])) {
            unlink($stagedFile['full_path']);
        }
        $success = false;
        $message = $e->getMessage();
    }
}

if (isset($_POST['cancel-transfer-request'])) {
    $requestId = sanitize(decipher($_POST['data-verifier'] ?? null));
    $showAlert = true;
    $success = false;

    try {
        if (empty($requestId)) {
            throw new Exception('Invalid transfer request selected.');
        }

        $request = getTransferRequest($requestId);
        if (!$request || $request['employee_id'] != $userId) {
            throw new Exception('The requested transfer request could not be found.');
        }

        if ($request['status'] !== 'Pending') {
            throw new Exception('Only pending transfer requests can be canceled.');
        }

        beginTransaction();

        $result = deleteTransferRequest($requestId, $userId);

        if ($result === false) {
            throw new Exception('We encountered an error canceling your request. Please try again later.');
        }

        commit();

        // Unlink attachment
        if (!empty($request['attachment_path']) && file_exists(root() . "/" . $request['attachment_path'])) {
            unlink(root() . "/" . $request['attachment_path']);
        }

        $success = true;
        $message = 'Your transfer request has been canceled successfully.';
        createSystemLog($stationId, $userId, 'Canceled transfer request', $userId, clientIp());

    } catch (Exception $e) {
        rollBack();
        $success = false;
        $message = $e->getMessage();
    }
}