<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
				header('location:https://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
foreach ($_GET as $key => $data)
{
	
$data2=$_GET[$key]=base64_decode(urldecode($data));
	
}
mysqli_query($con,"DELETE FROM tbl_section WHERE SecCode='".$data2."' LIMIT 1");
echo '<script>{alert("Successfully Deleted!!");window.location.href="?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=U2VjdGlvbg%3D%3D";}</script>';
?>	
