<?php
// dmis/app.php
restrictPublicAccess();

$activeApp = $_SESSION[alias() . '_activeApp'] = 'dmis';
$page = $appTitle = "Division Management Information System";

if (!isset($userId)) {
  redirect(uri() . '/login');
}

if (numRows(userRole($userId, $activeApp)) === 0) {
  redirect(uri() . '/pis');
}

if (isset($_POST['primary-search-button'])) {
  redirect(customUri('dmis', 'Search', sanitize($_POST['primary-search-text'])));
}

if (isset($_POST['reset-user'])) {
  $employeeId = sanitize(decipher($_POST['verifier']));
  $temporaryPassword = sanitize(decipher($_POST['data-verifier']));

  $showAlert = true;
  $message = 'User password has been reset successfully. ' . $temporaryPassword;
  $success = true;
}

if (isset($_POST['remove-user'])) {
  $showAlert = true;
  $message = 'User has been removed successfully.';
  $success = true;
}
?>