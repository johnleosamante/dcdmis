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
?>