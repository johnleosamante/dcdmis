<?php
// modules/settings/app.php
$oldPassword = $password = $passwordConfirm = $generatePassword = null;

if (isset($_POST['update-password'])) {
  $showAlert = true;
  $success = false;
  $oldPassword = sanitize($_POST['old-password']);
  $password = sanitize($_POST['password']);
  $passwordConfirm = sanitize($_POST['password-confirm']);
  $generatePassword = sanitize($_POST['generate-password']);

  if (empty($oldPassword) || empty($password) || empty($passwordConfirm)) {
    $message = 'All fields in asterisk (*) are required.';
    return;
  }

  if (numRows(account($email, hashPassword($oldPassword))) === 0) {
    $message = 'You have entered an incorrect old password.';
    $oldPassword = $password = $passwordConfirm = $generatePassword = null;
    return;
  }

  if ($password !== $passwordConfirm) {
    $message = 'The new password you entered do not match.';
    return;
  }

  if (!checkPasswordStrength($passwordConfirm)) {
    $message = 'The new password you entered does not meet the recommendations specified below.';
    return;
  }

  if ($passwordConfirm === $oldPassword) {
    $message = 'The new password you entered matches your old password.';
    return;
  }

  updateAccountPassword($email, hashPassword($passwordConfirm));

  if (affectedRows()) {
    $message = 'Your password has been updated successfully.';
    $success = true;
    $oldPassword = $password = $passwordConfirm = $generatePassword = null;
    createSystemLog($stationId, $userId, 'Updated password', $userId, clientIp());
  }
}

if (isset($_POST['update-contact-details'])) {
  $alternateEmail = sanitize($_POST['alternate-email']);
  $alternateMobile = sanitize($_POST['alternate-mobile']);

  updateEmployeeContactDetails($alternateMobile, $alternateEmail, $userId);

  if (affectedRows()) {
    $showAlert = true;
    $message = 'Your contact details have been updated successfully.';
    $success = true;
    createSystemLog($stationId, $userId, 'Updated contact details', $userId, clientIp());
  }
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

  if (affectedRows()) {
    $showAlert = true;
    $message = 'Your identification details have been updated successfully.';
    $success = true;
    createSystemLog($stationId, $userId, 'Updated identification details', $userId, clientIp());
  }
}

if (isset($_POST['update-professional-titles'])) {
  $before = sanitize($_POST['before-title']);
  $after = sanitize($_POST['after-title']);

  updateProfessionalTitles($before, $after, $userId);

  if (affectedRows()) {
    $showAlert = true;
    $message = 'Your professional titles have been updated successfully.';
    $success = true;
    createSystemLog($stationId, $userId, 'Updated professional titles', $userId, clientIp());
  }
}
?>