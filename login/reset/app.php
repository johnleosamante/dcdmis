<?php
// login/reset/app.php
$appTitle = $page = 'Forgot Password';
$userEmail = null;

if (isset($_POST['reset-password'])) {
    $showAlert = true;
    $success = false;
    $message = "If an account is associated with this email, you will receive instructions shortly.";

    $userEmail = sanitize($_POST['email']);

    if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
        return;
    }

    if (!isValidEmail($userEmail, 'deped.gov.ph')) {
        $message = 'Please use an authorized @deped.gov.ph email address.';
        return;
    }

    $account = account($userEmail);

    if (!$account) {
        $success = true;
        error_log("Reset attempted for non-existent email: {$userEmail}");
        return;
    }

    $employeeId = $account['id'];
    $temporaryPassword = generateStrongRandomPassword();
    updateAccountPassword($employeeId, hashPassword($temporaryPassword), 'Default');

    $subject = "Employee Password Reset";
    $loginUrl = "{$baseUri}/login";

    $emailBody = "Good day!\n\n
                Your request for password reset has been approved!\n\n
                Your temporary password is: {$temporaryPassword}\n\n
                Please login to: {$loginUrl} to confirm.\n\n
                If you did not request this change please contact us for assistance. Thank you.";

    if (!sendMail($userEmail, $subject, $emailBody)) {
        $message = "We encountered an error sending the email. Please try again later.";
        error_log("Failed to send reset email to: {$userEmail}");
        return;
    }

    $success = true;
}