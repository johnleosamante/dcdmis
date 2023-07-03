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
  $from = sanitize($_POST['from']);
  $to = sanitize($_POST['to']);
  $type = sanitize($_POST['type']);
  $sponsor = sanitize($_POST['sponsor']);
  $venue = sanitize($_POST['venue']);

  if (numRows(training($trainingId)) === 0) {
    $status = 'saved';
    createTraining($title, $from, $to, $type, $sponsor, $venue);
  } else {
    $status = 'updated';
    updateTraining($title, $from, $to, $type, $sponsor, $venue, $trainingId);
  }

  if (affectedRows()) {
    $showResult = true;
    $success = true;
    $message = "Training has been {$status} successfully.";
  }
}
?>