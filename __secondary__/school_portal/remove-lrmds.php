<?php
session_start();
include("../vendor/jquery/function.php");
if ($_GET['Category']=='Secondary')
{
	mysqli_query($con,"DELETE FROM tbl_secondary_subject WHERE SubNo='".$_GET['id']."' LIMIT 1");
}elseif ($_GET['Category']=='Elementary')
{
	mysqli_query($con,"DELETE FROM tbl_elementary_subject WHERE SubNo='".$_GET['id']."' LIMIT 1");
}

echo '<script>{
	alert("You have successfully deleted!!");
	window.location.href="lrmds-report.php?link=10a638b057cff7770c37024121ccb27e2f18f791";
}</script>';
?>