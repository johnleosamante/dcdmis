<?php
session_start();
include("../vendor/jquery/function.php");
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");

mysqli_query($con,"INSERT INTO reply VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_POST['message']."','".$_SESSION['chat-id']."')");
?>