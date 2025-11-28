<?php
// hrmpsb/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrmpsb';
$page = $appTitle = 'Human Resource Management Personnel Selection Board';

if (!isset($userId)) {
    redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
    redirect(uri() . '/pis');
}

if (isset($_POST['save-vacancy'])) {
    $vacancyId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
    $position = null;
    $positionId = $_POST['position'] ?? null;
    $itemNumber = $_POST['item_number'] ?? null;
    $stationId = $_POST['station'] ?? null;
    $datePosted = $_POST['date_posted'] ?? date('Y-m-d');
    $showAlert = true;
    $status = 'Added vacancy';

    if (empty($vacancyId)) {
        $position = strtoupper(fetchAssoc(positions($positionId))['position']);

        createVacancy('open', $positionId, $stationId, $itemNumber, null, $datePosted, 'new', $userId);
        $message = "Vacancy for [$position] with item number [$itemNumber] has been added successfully.";
    } else {
        $vacancy = fetchAssoc(vacancy($vacancyId));
        $vacancyStatus = $vacancy['status'] ?? null;
        $vacancyPosition = $vacancy['position_id'] ?? null;
        $vacancyReason = $vacancy['reason'] ?? null;
        $itemNumber = empty($vacancy['psipop']) ? $itemNumber : $vacancy['psipop'];
        updateVacancy($vacancyId, $vacancyStatus, $vacancyPosition, $stationId, $itemNumber, $datePosted, $vacancyReason, $userId);
        $status = 'Updated vacancy';
        $messages = "Vacancy for [$position] with item number [$itemNumber] has been updated successfully.";
    }

    if (affectedRows()) {
        createSystemLog($stationId, $userId, $status, $itemNumber, clientIp());
    } else {
        $message = 'Vacancy was not saved successfully.';
        $success = false;
    }
}

if (isset($_POST['publish-vacancies'])) {
    $showAlert = true;
    $status = 'Vacancies Published';
}
