<?php
// hrtdms/app.php
if (isPublicDomain()) {
  redirect(uri() . '/oops?e=403');
}

restrictPublicAccess(hasHoliday());

$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrtdms';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
  redirect(uri() . '/pis');
}

$page = $appTitle = 'Human Resource Training &amp; Development Management System';

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('hrtdms', 'Training Details', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['save-training'])) {
  $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $title = sanitize($_POST['title']);
  $from = sanitize($_POST['from']);
  $to = sanitize($_POST['to']);
  $hours = sanitize($_POST['hours']);
  $type = sanitize($_POST['type']);
  $sponsor = sanitize($_POST['sponsor']);
  $venue = sanitize($_POST['venue']);
  $logMessage = '';
  $unconsecutiveDates = sanitize($_POST['unconsecutive-dates']);
  $hasCertificate = isset($_POST['has-certificate']) ? '1' : '0';

  $signatory = isset($_POST['has-certificate']) ? fetchAssoc(section('SDS'))['head'] : null;

  if (numRows(training($trainingId)) === 0) {
    $logMessage = 'Added training';
    $status = 'saved';
    $year = toDate($from, 'y', date('y'));
    $trainingId = 'HRTD-' . $year . '-' . sprintf("%04d", countTrainings($year) + 1);

    createTraining($trainingId, $title, $from, $to, $hours, $type, $sponsor, $venue, $unconsecutiveDates, $signatory, $hasCertificate);
  } else {
    $logMessage = 'Updated training';
    $status = 'updated';

    updateTraining($trainingId, $title, $from, $to, $hours, $type, $sponsor, $venue, $unconsecutiveDates, $signatory, $hasCertificate);
  }

  $showAlert = true;

  if (affectedRows()) {
    $message = 'Training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>] has been ' . $status . ' successfully.';

    createSystemLog($stationId, $userId, $logMessage, $trainingId, clientIp());
  } else {
    $message = $status === 'saved' ? 'No new training has been created.' : 'No training has been updated';
    $success = false;
  }
}

if (isset($_POST['add-participants'])) {
  $showAlert = true;

  if (!isset($_POST['participants'])) {
    $message = 'No training participant was added to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
    $success = false;
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
    $message = $no . ' training participant' . $noun . ' added successfully to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';

    createSystemLog($stationId, $userId, 'Added ' . $no . ' training participants', $trainingId, clientIp());
  } else {
    $message = 'No training participant was added to training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
    $success = false;
  }
}

if (isset($_POST['remove-participant'])) {
  $participantId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $trainingId = isset($_POST['data-verifier']) ? sanitize(decipher($_POST['data-verifier'])) : null;
  
  deleteTrainingParticipant($trainingId, $participantId);

  $showAlert = true;

  if (affectedRows()) {
    $message = 'Employee [<a href="#" title="View ' . userName($participantId) . ' employee information">' . userName($participantId) . '</a>] has been successfully removed as participant from training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
    
    createSystemLog($stationId, $userId, 'Removed training participant', $trainingId, clientIp());
  } else {
    $message = 'Employee [<a href="#" title="View ' . userName($participantId) . ' employee information">' . userName($participantId) . '</a>] was not removed as participant from training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details">' . strtoupper($trainingId) . '</a>].';
    $success = false;
  }
}
?>