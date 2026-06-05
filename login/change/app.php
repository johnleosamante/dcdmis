<?php
// login/change/app.php

if (!isset($_SESSION["{$prefix}change_password"]) || $_SESSION["{$prefix}change_password"] !== true) {
    redirect("{$baseUri}/login");
}

$appTitle = $page = 'Change Password';
$email = $_SESSION["{$prefix}email"] ?? '';
$password = $passwordConfirm = null;

if (isset($_POST['change-password'])) {
    $showAlert = true;
    $success = false;
    $password = sanitize($_POST['password']);
    $passwordConfirm = sanitize($_POST['password-confirm']);

    if (empty($password) || empty($passwordConfirm)) {
        $message = 'All fields in asterisk (*) are required.';
        return;
    }

    if ($password !== $passwordConfirm) {
        $message = 'The new password you entered does not match.';
        return;
    }

    if (!checkPasswordStrength($passwordConfirm)) {
        $message = 'The new password you entered does not meet the requirements specified above.';
        return;
    }

    $affectedAccountPassword = updateAccountPassword($userId, hashPassword($passwordConfirm), 'Changed');

    if ($affectedAccountPassword === false) {
        $message = 'We encountered an error on our end. Please try again later.';
        $password = $passwordConfirm = null;
        return;
    }

    if ($affectedAccountPassword === 0) {
        $message = 'No changes have been made to your password';
    } else {
        $success = true;
        $oldPassword = $password = $passwordConfirm = $generatePassword = null;

        createSystemLog($stationId, $userId, 'Updated password', $userId, clientIp());
        unset($_SESSION["{$prefix}change_password"]);
    }

    redirect("{$baseUri}/login");
}