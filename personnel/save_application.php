<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO tbl_online_application VALUES('".$_POST['TrackNo']."','".date("Y-m-d")."','".$_SESSION['EmpID']."','".$_POST['newpost']."','For Confirmation and Approval','HRMO')")or die ('Error');
mysqli_query($con,"INSERT INTO tbl_application_log VALUES(NULL,'".date("Y-m-d")."','".$_SESSION['Per_Name']."','Online Application','Teacher','".$_POST['TrackNo']."')")or die ("Error Log");
?>
<script>
{
	alert("Successfully submitted!!");
	window.location.href='./';
}
</script>
