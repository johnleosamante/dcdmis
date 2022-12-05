<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");
mysqli_query($con,"UPDATE tbl_transactions_log SET Status='Done' WHERE Transaction_code='".$_GET['id']."'");

mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='Completed',Status='Read' WHERE TransCode='".$_GET['id']."' LIMIT 1");		
mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES (NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','-','Completed','".$_GET['id']."','Done')");						
echo '<script>
  {
	alert("Successfully Released!!");
	window.location.href="./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=ZGFzaGJvYXJk";
	}</script>';


?>