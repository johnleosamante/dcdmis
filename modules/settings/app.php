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

  if (affectedRows() === 1) {
    $message = 'Your password has been updated successfully.';
    $success = true;
    $oldPassword = $password = $passwordConfirm = $generatePassword = null;
  }
}

if (isset($_POST['update-contact-details'])) {
  $alternateEmail = sanitize($_POST['alternate-email']);
  $alternateMobile = sanitize($_POST['alternate-mobile']);

  updateEmployeeContactDetails($alternateMobile, $alternateEmail, $userId);

  if (affectedRows() === 1) {
    $showAlert = true;
    $message = 'Your contact details have been updated successfully.';
    $success = true;
  }
}
?>