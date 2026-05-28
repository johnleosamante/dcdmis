<?php
// include/initialization.php
ini_set('session.name', 'DCDMIS_SESSION');
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

session_start();

if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net code.jquery.com cdn.datatables.net; style-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com cdn.datatables.net; img-src 'self' data: blob:; font-src 'self' fonts.gstatic.com; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'self';");
    header_remove('X-Powered-By');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

date_default_timezone_set("Asia/Manila");
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '25M');
ini_set('memory_limit', '256M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('display_errors', 0);
if (!empty(ERROR_LOG_FILE)) {
    ini_set('error_log', ERROR_LOG_FILE);
}
ini_set('log_errors', 1);
define('FILE_UPLOAD_SIZE_LIMIT', uploadMaxBytes());

const HOME = 'pis';
$prefix = alias() . '_';
$baseUri = uri();
$enableScripts = false;
$showAlert = false;
$message = null;
$success = false;
$activeApp = $_SESSION["{$prefix}activeApp"] ?? HOME;
$activeTab = $_SESSION["{$prefix}activeTab"] ?? null;
$userId = $_SESSION["{$prefix}userId"] ?? null;
$stationId = $_SESSION["{$prefix}stationId"] ?? null;
$station = $_SESSION["{$prefix}station"] ?? null;
$code = $_SESSION["{$prefix}code"] ?? null;
$portal = $_SESSION["{$prefix}portal"] ?? null;
$hasPortal = !empty($portal);
$isSchoolPortal = $portal === 'sch_portal';
$isRecordsPortal = $portal === 'rec_portal';
$isAdminPortal = $portal === 'adm_portal';
$isPersonnel = $code === 'PER';

if (function_exists('verify_csrf_token')) {
    verify_csrf_token();
}