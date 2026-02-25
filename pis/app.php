<?php
// pis/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'pis';
$page = $appTitle = 'Personnel Information System';

if (!isset($userId)) {
    redirect(uri() . '/login');
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

    $identication = !employeeIdentification($userId) ?
        createIdentification($card, $number, $place, $date, $userId) :
        updateIdentification($card, $number, $place, $date, $userId);

    if ($identication) {
        $message = 'Government issued ID has been updated successfully.';
        createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
    } else {
        $message = 'No changes have been made to government issued ID.';
        $success = false;
    }
}

if (isset($_POST['save-payslip'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $payslipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $description = sanitize($_POST['description']);
    $filename = isset($_POST['file-verifier']) ? sanitize(decipher($_POST['file-verifier'])) : null;
    $ext = $logMessage = '';
    $message = 'No changes have been made to payslip.';
    $showAlert = true;
    $success = false;

    if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
        $temp = $_FILES['file-upload']['tmp_name'];

        if ($_FILES['file-upload']['size'] > $fileUploadSizeLimit) {
            $message = 'The choosen file exceeds the upload file limit (20 MB). No changes have been made to payslip.';
            return;
        }

        $mimeType = mime_content_type($temp);
        $allowedFileTypes = ['application/pdf', 'image/png', 'image/jpeg'];

        if (!in_array($mimeType, $allowedFileTypes)) {
            $message = 'The choosen file is not an acceptable file (pdf, png, jpeg). No changes have been made to payslip.';
            return;
        }

        $ext = pathinfo($_FILES['file-upload']['name'], PATHINFO_EXTENSION);

        if (!empty($filename) && file_exists(root() . '/' . $filename)) {
            unlink(root() . '/' . $filename);
        }

        $filename = "uploads/payslip/{$employeeId}/{$employeeId}-" . date('YmdHis') . ".{$ext}";

        move_uploaded_file($temp, '../' . $filename);
    }

    if (empty($filename)) {
        $message = 'No changes have been made to payslip.';
        $success = false;
        return;
    } else {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
    }

    if (!payslip($employeeId, $payslipId)) {
        $payslip = createPayslip($description, $filename, $ext, $employeeId);

        $logMessage = 'Added payslip';
        $message = 'Payslip has been added successfully.';
    } else {
        $payslip = updatePayslip($description, $filename, $ext, $employeeId, $payslipId);

        $logMessage = 'Updated payslip';
        $message = 'Payslip has been updated successfully.';
    }

    if (!$payslip) {
        $message = 'No changes have been made to payslip.';
        return;
    }

    createSystemLog($stationId, $userId, $logMessage, $employeeId, clientIp());
    $success = true;
}


if (isset($_POST['delete-payslip'])) {
    $employeeId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $payslipId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
    $showAlert = true;
    $filename = null;
    $file = payslip($employeeId, $payslipId);
    $payslip = [];

    if ($file) {
        $filename = $file['file_name'];
        $payslip = deletePayslip($employeeId, $payslipId);
    }

    if ($payslip) {
        createSystemLog($stationId, $userId, 'Deleted employee payslip', $employeeId, clientIp());
        unlink(root() . '/' . $filename);
        $message = 'Payslip has been deleted successfully.';
    } else {
        $message = 'No changes have been made to payslip.';
        $success = false;
    }
}