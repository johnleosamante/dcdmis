<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");

mysqli_query($con,"INSERT INTO reply VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_POST['message']."','".$_SESSION['chatid']."','ITO')");
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")));
?>