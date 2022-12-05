<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");
mysqli_query($con,"UPDATE tbl_transactions_log SET Status='Done' WHERE Transaction_code='".$url."'");

mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='Completed',Status='Read' WHERE TransCode='".$url."' LIMIT 1");		
mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES (NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','-','Completed','".$url."','Done')");						
echo '<script>{alert("Successfully Released!!");window.location.href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'";}</script>';


?>