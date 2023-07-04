<?php
// hrtdms/app.php
restrictPublicAccess();

$activeApp = $_SESSION[alias() . '_activeApp'] = 'hrtdms';
$page = $appTitle = 'Human Resource Training &amp; Development Management System';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
  redirect(uri() . '/pis');
}

if (isset($_POST['save-training'])) {
  $trainingId = isset($_POST['verifier']) ? sanitize(decipher($_POST['verifier'])) : null;
  $title = sanitize($_POST['title']);
  $from = isset($_POST['from']) ? sanitize($_POST['from']) : date('Y-m-d');
  $to = sanitize($_POST['to']);
  $type = sanitize($_POST['type']);
  $sponsor = sanitize($_POST['sponsor']);
  $venue = sanitize($_POST['venue']);

  if (numRows(training($trainingId)) === 0) {
    $status = 'saved';
    $year = toDate($from, 'y', date('y'));
    $trainingId = 'HRTD-' . $year . '-' . sprintf("%04d", countTrainings($year) + 1);
    createTraining($trainingId, $title, $from, $to, $type, $sponsor, $venue);
  } else {
    $status = 'updated';
    updateTraining($trainingId, $title, $from, $to, $type, $sponsor, $venue);
  }

  if (affectedRows()) {
    $showAlert = true;
    $success = true;
    $message = 'Training code [<a href="' . customUri('hrtdms', 'Training Details', $trainingId) . '" title="View ' . $trainingId . ' training details" target="_blank">' . strtoupper($trainingId) . '</a>] has been ' . $status . ' successfully.';
  }
}
?>