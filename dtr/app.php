<?php
// pis/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'dtr';
$page = $appTitle = 'Daily Time Record';
$showAlert = false;
$message = '';
$success = false;

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (!userRole($userId, $activeApp)) {
    redirect("{$baseUri}/" . HOME);
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}