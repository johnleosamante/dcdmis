<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_online_application SET Transaction_status='For Evaluation and Assessment',Transaction_office='HRMO' WHERE Emp_ID='".$_SESSION['EmpID']."' AND Transaction_number ='".$_SESSION['TCode']."' LIMIT 1");
mysqli_query($con,"INSERT INTO tbl_application_log VALUES(NULL,'".date("Y-m-d")."','".$_SESSION['Per_Name']."','Printing Documents','Teacher','".$_SESSION['TCode']."')")or die ("Error Log");

?>
<script>
{
	alert("Successfully Print..Ready for Evaluation and Assessment..");
	window.location.href='view_information.php';
}
</script>