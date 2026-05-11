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
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' cdn.jsdelivr.net code.jquery.com cdn.datatables.net; style-src 'self' 'unsafe-inline' cdn.jsdelivr.net fonts.googleapis.com cdn.datatables.net; img-src 'self' data:; font-src 'self' fonts.gstatic.com; frame-ancestors 'self'");
    header_remove('X-Powered-By');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

date_default_timezone_set("Asia/Manila");
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1024M');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php-errors.log');

function custom_error_handler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        return false;
    }
    $error_id = uniqid('ERR-');
    $error_message = "[$error_id] Error: [$errno] $errstr in $errfile on line $errline";
    error_log($error_message);
    if (!headers_sent()) {
        http_response_code(500);
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $domain = $_SERVER['HTTP_HOST'];
        $base = "{$protocol}{$domain}";
        include_once($_SERVER['DOCUMENT_ROOT'] . '/oops/500.php');
        exit;
    }
}

set_error_handler("custom_error_handler");

function custom_exception_handler($exception)
{
    $error_id = uniqid('EXC-');
    $error_message = "[$error_id] Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine();
    error_log($error_message);
    if (!headers_sent()) {
        http_response_code(500);
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $domain = $_SERVER['HTTP_HOST'];
        $base = "{$protocol}{$domain}";
        include_once($_SERVER['DOCUMENT_ROOT'] . '/oops/500.php');
        exit;
    }
}

set_exception_handler("custom_exception_handler");

const FILE_UPLOAD_SIZE_LIMIT = 1024 * 1024 * 20; // 20MB
const IMAGE_UPLOAD_SIZE_LIMIT = 1024 * 1024 * 2.5; // 2.5MB
const HOME = 'pis'; // default home page

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
$isPersonnel = $code === 'PER';

if (function_exists('verify_csrf_token')) {
    verify_csrf_token();
}