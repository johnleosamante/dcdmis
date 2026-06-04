<?php
// login/reset/app.php
$appTitle = $page = 'Forgot Password';
$userEmail = null;

if (isset($_POST['reset-password'])) {
    $showAlert = true;
    $success = false;
    $userEmail = sanitize($_POST['email']);

    if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        return;
    }

    if (!isValidEmail($userEmail, 'deped.gov.ph')) {
        $message = 'Please use an authorized @deped.gov.ph email address.';
        return;
    }

    $message = "If an account is associated with this email, you will receive instructions shortly.";
    $account = account($userEmail);

    if (!$account) {
        $success = true;
        error_log("Reset attempted for non-existent email context profile: {$userEmail}");
        return;
    }

    $employeeId = $account['id'];
    $temporaryPassword = generateStrongRandomPassword();
    $targetDeliveryEmail = PRODUCTION_MODE ? $userEmail : DEVELOPER_EMAIL;

    if (updateAccountPassword($employeeId, hashPassword($temporaryPassword), 'Default') === false) {
        $success = false;
        $message = "We encountered an error on our end. Please try again later.";
        return;
    }

    $subject = "Employee Password Reset Request";
    $loginUrl = "{$baseUri}/login";

    $emailBody = "Good day!\n\n
        Your request for a password reset has been approved!\n\n
        Your temporary password is: {$temporaryPassword}\n\n
        Please login to: {$loginUrl} to update your credentials.\n\n
        If you did not request this change, please contact system administration immediately. Thank you.";

    if (!sendMail($targetDeliveryEmail, $subject, $emailBody)) {
        $success = false;
        $message = "We encountered an error sending the system modification email. Please try again later.";
        error_log("Failed to execute sendMail tracking sequence targeting: {$userEmail} (Routed to: {$targetDeliveryEmail})");
        return;
    }

    $success = true;
}