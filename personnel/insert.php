<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");

mysqli_query($con,"INSERT INTO tbl_chat VALUES(NULL,'".$_POST['message']."','".$dateposted."','".$_SESSION['EmpID']."','Unread','".$_SESSION['chatID']."')");
echo "Send";
?>