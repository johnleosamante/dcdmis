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
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }

    $success = true;

    if ($result === 0) {
        $message = 'No changes have been made to government issued ID.';
        return;
    }

    $message = 'Government issued ID has been updated successfully.';

    createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
}

if (isset($_POST['save-payslip'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $payslipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $description = sanitize($_POST['description']);
    $oldFilename = isset($_POST['file-verifier']) ? sanitize(decipher($_POST['file-verifier'])) : null;
    $newFilename = $oldFilename;
    $showAlert = true;

    if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
        $temp = $_FILES['file-upload']['tmp_name'];

        if ($_FILES['file-upload']['size'] > FILE_UPLOAD_SIZE_LIMIT) {
            $message = 'The choosen file exceeds the upload file limit (20 MB). No changes have been made to payslip.';
            return;
        }

        if (mime_content_type($temp) !== 'application/pdf') {
            $message = 'The choosen file is not an acceptable file (pdf). No changes have been made to payslip.';
            return;
        }

        $ext = pathinfo($_FILES['file-upload']['name'], PATHINFO_EXTENSION);
        $newFilename = "uploads/payslip/{$employeeId}/{$employeeId}-" . date('YmdHis') . ".{$ext}";

        if (!move_uploaded_file($temp, "../{$newFilename}")) {
            $message = 'Failed to upload payslip.';
            return;
        }

        if (!empty($oldFilename) && file_exists(root() . "/{$oldFilename}")) {
            unlink(root() . "/{$oldFilename}");
        }
    }

    if (empty($newFilename)) {
        $message = 'No changes have been made to payslip.';
        return;
    }

    $ext = pathinfo($newFilename, PATHINFO_EXTENSION);
    $hasExistingRecord = payslip($employeeId, $payslipId);



    if (!$hasExistingRecord) {
        $result = createPayslip($description, $newFilename, $ext, $employeeId);
        $logMessage = 'Added payslip';
    } else {
        $result = updatePayslip($description, $newFilename, $ext, $employeeId, $payslipId);
        $logMessage = 'Updated payslip';
    }

    if ($result === false) {
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }

    $success = true;

    if ($result === 0 && $hasExistingRecord) {
        $message = 'No changes have been made to payslip.';
        return;
    }

    $message = "Payslip has been " . ($hasExistingRecord ? "updated" : "added") . " successfully.";

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
}


if (isset($_POST['delete-payslip'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $payslipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $filename = null;
    $file = payslip($employeeId, $payslipId);
    $result = false;

    if ($file) {
        $filename = $file['file_name'];
        $result = deletePayslip($employeeId, $payslipId);
    }

    if ($result === false) {
        $message = 'We encountered an error on our end. Please try again later.';
        return;
    }

    $success = true;

    if ($result === 0) {
        $message = 'No changes have been made to payslip.';
        return;
    }

    $message = 'Payslip has been deleted successfully.';

    unlink(root() . '/' . $filename);
    createSystemLog($stationId, $userId, 'Deleted employee payslip', $employeeId, clientIp());
}