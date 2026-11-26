<?php
// hrmsuite/app.php
$activeApp = $_SESSION["{$prefix}activeApp"] = 'hrmsuite';
$page = $appTitle = 'Human Resource Management Suite';
$showAlert = false;
$message = '';
$success = false;

if (!isset($userId)) {
    redirect("{$baseUri}/login");
}

if (isset($_SESSION["{$prefix}change_password"])) {
    redirect("{$baseUri}/login/change");
}

$userPositionId = position($userId)['position_id'] ?? null;
$showOverview = in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT;

if (!$showOverview) {
    redirect("{$baseUri}/" . HOME);
}

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
    $from = date('Y-m-d', strtotime($_POST['date-from']));
    $to = date('Y-m-d', strtotime($_POST['date-to']));
    $currentView = isset($_GET['v']) ? sanitize(decipher($_GET['v'])) : 'Conducted Trainings';
    redirect(customUri('hrmsuite', $currentView) . '&from=' . $from . '&to=' . $to);
}