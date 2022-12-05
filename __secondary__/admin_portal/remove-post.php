<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
mysqli_query($con,"DELETE FROM post WHERE id='".$_GET['id']."' LIMIT 1");	
echo '<script>{alert("Successfully deleted!!");window.location.href="announcement.php?url=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9%27";}</script>';	

?>