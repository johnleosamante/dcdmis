<?php
// include/initialization.php
session_start();
date_default_timezone_set("Asia/Manila");
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '1024M');
ini_set('display_errors', 0);

$userId = isset($_SESSION[alias() . '_userId']) ? $_SESSION[alias() . '_userId'] : null;
$stationId = isset($_SESSION[alias() . '_stationId']) ? $_SESSION[alias() . '_stationId'] : null;
$station = isset($_SESSION[alias() . '_station']) ? $_SESSION[alias() . '_station'] : null;
$activeApp = isset($_SESSION[alias() . '_activeApp']) ? $_SESSION[alias() . '_activeApp'] : 'pis';
$activeTab = isset($_SESSION[alias() . '_activeTab']) ? $_SESSION[alias() . '_activeTab'] : null;
$code = isset($_SESSION[alias() . '_code']) ? $_SESSION[alias() . '_code'] : null;
$portal = isset($_SESSION[alias() . '_portal']) ? $_SESSION[alias() . '_portal'] : null;
$hasPortal = !empty($portal);
$isSchoolPortal = $portal === 'sch_portal';
$isRecordsPortal = $portal === 'rec_portal';
$isDescriptionEditable = isset($_SESSION[alias() . '_editableDescription']) ? $_SESSION[alias() . '_editableDescription'] : false;
$showAlert = false;
$message = null;
$success = true;
?>