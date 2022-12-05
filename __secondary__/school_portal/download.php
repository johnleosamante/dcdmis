<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");		
mysqli_query($con,"UPDATE tbl_list_of_modules SET No_of_download=No_of_download + 1 WHERE No='".$_GET['id']."' LIMIT 1");

mysqli_query($con,"INSERT tbl_download_history VALUES(NULL,'".$_SESSION['uid']."','".$dateposted."','".$_GET['id']."','".$_SESSION['school_id']."')");

$result=mysqli_query($con,"SELECT * FROM tbl_list_of_modules WHERE No='".$_GET['id']."' LIMIT 1");	
$row=mysqli_fetch_assoc($result);

echo '<iframe width="100%" height="100%" src="'.$row['filelocation'].'" frameborder="0"></iframe>';
						
?>