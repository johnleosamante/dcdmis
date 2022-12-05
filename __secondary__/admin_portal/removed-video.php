<?php
session_start();
include("../vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
$query=mysqli_query($con,"SELECT * FROM tbl_video WHERE FileCode='".$_GET['id']."' LIMIT 1");
$row=mysqli_fetch_assoc($query);		
mysqli_query($con,"DELETE FROM tbl_video WHERE FileCode='".$_GET['id']."' LIMIT 1");
unlink($row['FileLocation']);
echo '<script>{alert("Successfully deleted!!");window.location.href="manage-video.php?url=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9%27";}</script>';	

?>