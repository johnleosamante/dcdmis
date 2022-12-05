<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
	mysqli_query($con,"DELETE FROM tbl_list_of_modules WHERE No='".$_GET['id']."' LIMIT 1");	
	header("location:list_of_modules.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c");
?>