<?php
// hrtdms/repository/app.php
$appTitle = $page = !MAINTENANCE_MODE ? 'Division Training Certificate Finder' : 'System Maintenance';
$enableScripts = true;

$from = isset($_GET['from']) ? sanitize($_GET['from']) : date('Y') . '-01-01';
$to = isset($_GET['to']) ? sanitize($_GET['to']) : date('Y-m-d');

if (isset($_POST['transactions-summary-filter'])) {
    $from = date('Y-m-d', strtotime($_POST['date-from']));
    $to = date('Y-m-d', strtotime($_POST['date-to']));
    redirect(customUri('hrtdms/repository', '') . '&from=' . $from . '&to=' . $to);
}