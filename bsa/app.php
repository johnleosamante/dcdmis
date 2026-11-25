<?php
// bsa/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'bsa';
$page = $appTitle = 'Booking & Schedule';
$showAlert = false;
$message = '';
$success = false;

if (empty($userId)) {
    redirect("{$baseUri}/login");
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}

$currentView = isset($_GET['v']) ? sanitize(decode($_GET['v'])) : null;
if ($currentView !== 'Booking Approvals') {
    foreach (['dtcsc_flash', 'vehicle_flash', 'joborder_flash'] as $bsaFlashKey) {
        if (!empty($_SESSION[$bsaFlashKey])) {
            $flashData = $_SESSION[$bsaFlashKey];
            unset($_SESSION[$bsaFlashKey]);
            $showAlert = true;
            $message = e($flashData['message'] ?? '');
            $success = (($flashData['type'] ?? '') === 'success');
            break;
        }
    }
}