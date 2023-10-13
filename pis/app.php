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

  if (numRows(employeeIdentification($userId)) === 0) {
    createIdentification($card, $number, $place, $date, $userId);
  } else {
    updateIdentification($card, $number, $place, $date, $userId);
  }

  if (affectedRows()) {
    $message = 'Government issued ID has been updated successfully.';
    createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
  } else {
    $message = 'No changes have been made to government issued ID.';
    $success = false;
  }
}
?>