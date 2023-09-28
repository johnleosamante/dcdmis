<?php
// pis/app.php
$activeApp = $_SESSION[alias() . '_activeApp'] = 'pis';

if (!isset($userId)) {
  redirect(uri() . '/login');
}

$page = $appTitle = 'Personnel Information System';

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('pis', 'Search', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['update-identification'])) {
  $card = sanitize($_POST['card-type']);
  $number = sanitize($_POST['card-number']);
  $place = sanitize($_POST['card-place']);
  $date = sanitize($_POST['card-date']);

  if (numRows(employeeIdentification($userId)) === 0) {
    createIdentification($card, $number, $place, $date, $userId);
  } else {
    updateIdentification($card, $number, $place, $date, $userId);
  }

  $showAlert = true;

  if (affectedRows()) {
    $message = 'Your identification details have been updated successfully.';
    createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
  } else {
    $message = 'No changes have been made to your identification details.';
    $success = false;
  }
}
?>