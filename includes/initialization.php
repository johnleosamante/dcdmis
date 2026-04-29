<?php
// include/initialization.php
session_start();
date_default_timezone_set("Asia/Manila");
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1024M');
ini_set('display_errors', 1);

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