<?php
// hrtdms/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrtdms';
$page = $appTitle = 'Human Resource Training &amp; Development Management System';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
  redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('hrtdms', 'Training Details', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['save-training'])) {
  $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $title = sanitize($_POST['title']);
  $from = isset($_POST['from']) ? sanitize($_POST['from']) : date('Y-m-d');
  $to = sanitize($_POST['to']);
  $type = sanitize($_POST['type']);
  $sponsor = sanitize($_POST['sponsor']);
  $venue = sanitize($_POST['venue']);
  $logMessage = '';

  if (numRows(training($trainingId)) === 0) {
    $logMessage = 'Added training';
    $status = 'saved';
    $year = toDate($from, 'y', date('y'));
    $trainingId = 'HRTD-' . $year . '-' . sprintf("%04d", countTrainings($year) + 1);
    createTraining($trainingId, $title, $from, $to, $type, $sponsor, $venue);
  } else {
    $logMessage = 'Updated training';
    $status = 'updated';
    updateTraining($trainingId, $title, $from, $to, $type, $sponsor, $venue);
  }

  if (affectedRows()) {
    $showAlert = true;
    $success = true;
    $message = 'Training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details" target="_blank">' . strtoupper($trainingId) . '</a>] has been ' . $status . ' successfully.';
    createSystemLog($stationId, $userId, $logMessage, $trainingId, clientIp());
  }
}

if (isset($_POST['add-participants'])) {
  $showAlert = true;

  if (!isset($_POST['participants'])) {
    $success = false;
    $message = 'No training participant was added.';
    return;
  }

  $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $participants = $_POST['participants'];
  $no = 0;
  
  foreach ($participants as $participant) {
    $id = sanitize(decipher($participant));
    if (!isTrainingParticipant($trainingId, $id)) {
      ++$no;
      createTrainingParticipant($trainingId, $id);
    }
  }

  if (affectedRows()) {
    $noun = $no === 1 ? ' was' : 's were';
    $success = true;
    $message = $no . ' training participant' . $noun . ' added successfully.';
    createSystemLog($stationId, $userId, 'Added ' . $no . ' training participants', $trainingId, clientIp());
  }
}

if (isset($_POST['remove-participant'])) {
  $participantId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $trainingId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  
  deleteTrainingParticipant($trainingId, $participantId);

  if (affectedRows()) {
    $showAlert = true;
    $success = true;
    $message = 'A participant has been removed successfully.';
    createSystemLog($stationId, $userId, 'Removed training participant', $trainingId, clientIp());
  }
}
?>