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
    $password = sanitize($_POST['password'] ?? '');
    $passwordConfirm = sanitize($_POST['password-confirm'] ?? '');

    if (empty($password) || empty($passwordConfirm)) {
        $message = 'All fields in asterisk (*) are required.';
        return;
    }

    if ($password !== $passwordConfirm) {
        $message = 'The new password you entered does not match.';
        return;
    }

    if (!checkPasswordStrength($passwordConfirm)) {
        $message = 'The new password you entered does not meet the requirements specified below.';
        return;
    }

    // 2. Database Execution Layer
    $affectedAccountPassword = updateAccountPassword($userId, hashPassword($passwordConfirm), 'Changed');

    if ($affectedAccountPassword === false) {
        $message = 'We encountered an error on our end. Please try again later.';
        $password = $passwordConfirm = null;
        return;
    }

    $success = true;
    $message = $affectedAccountPassword === 0 ?
        'No changes have been made to your password.' :
        'Your password has been updated successfully.';
    $password = $passwordConfirm = null;

    createSystemLog($stationId, $userId, 'Updated password via forced rotation context', $userId, clientIp());
    unset($_SESSION["{$prefix}change_password"]);
    redirect("{$baseUri}/login");
}