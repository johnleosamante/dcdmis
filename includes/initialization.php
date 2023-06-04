<?php
// include/initialization.php
session_start();
date_default_timezone_set("Asia/Manila");
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1024M');
//ini_set('display_errors', 0);

$activeApp = isset($_SESSION[alias() . '_activeApp']) ? $_SESSION[alias() . '_activeApp'] : null;
$userId = isset($_SESSION[alias() . '_userId']) ? $_SESSION[alias() . '_userId'] : null;
$email = isset($_SESSION[alias() . '_email']) ? $_SESSION[alias() . '_email'] : null;
$portal = isset($_SESSION[alias() . '_portal']) ? $_SESSION[alias() . '_portal'] : null;
$code = isset($_SESSION[alias() . '_code']) ? $_SESSION[alias() . '_code'] : null; // DTS specific
$stationId = isset($_SESSION[alias() . '_stationId']) ? $_SESSION[alias() . '_stationId'] : null;
$station = isset($_SESSION[alias() . '_station']) ? $_SESSION[alias() . '_station'] : null;
$isDescriptionEditable = isset($_SESSION[alias() . '_editableDescription']) ? $_SESSION[alias() . '_editableDescription'] : false; // DTS specific
$activeApp = isset($_SESSION[alias() . '_activeApp']) ? $_SESSION[alias() . '_activeApp'] : null;

$isSchoolPortal = $portal === 'school_portal'; // DTS specific
$isRecordsPortal = $portal === 'record_portal'; // DTS specific
$page = $appTitle = null;
$showPrompt = false;
$message = null;
$success = true;
?>