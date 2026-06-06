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
        $message = "Sorry, the email [{$userEmail}] is not an authorized email address.";
        return;
    }

    $message = "If an account is associated with this email, you will receive instructions shortly.";
    $account = account($userEmail);

    if (!$account) {
        $success = true;
        error_log("Reset attempted for non-existent email: {$userEmail}");
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

    $emailBody = <<<EOT
        A password reset request for your account ({$userEmail}) has been processed.

        Temporary Password: {$temporaryPassword}

        Please log in here to update your credentials: {$loginUrl}

        Security Note: If you did not request this change, please contact system administration immediately.

        Best regards,
        ICT Support Team
        EOT;

    if (!sendMail($targetDeliveryEmail, $subject, $emailBody)) {
        $success = false;
        $message = 'We encountered an error sending the password reset request email. Please try again later.';

        error_log("Failed to send reset request email to: {$userEmail} (Routed to: {targetDeliveryEmail}");

        return;
    }

    $success = true;
}