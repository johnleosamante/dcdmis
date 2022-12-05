<?php
session_start();
include("../vendor/jquery/function.php");
$query=mysqli_query($con,"SELECT * FROM tbl_request WHERE No='".$_SESSION['MyNo']."' LIMIT 1");
$data=mysqli_fetch_assoc($query);

if ($data['Request_status']=='Approved')
{
mysqli_query($con,"INSERT INTO tbl_leave_applied VALUES(NULL,'".$data['Date_apply']."','".$data['Request_for']."','".$_POST['payment']."','".$data['Number_of_days']."','".$_POST['reason_for_leave']."','On Leave','".$data['Request_From']."','".$data['Request_To']."','".$data['Emp_ID']."')");	
mysqli_query($con,"DELETE FROM tbl_request WHERE No='".$_SESSION['MyNo']."' LIMIT 1");
}else{
mysqli_query($con,"UPDATE tbl_request SET Request_status='For SDS Approval.' WHERE No='".$_GET['code']."' AND Emp_ID='".$_GET['TIN']."'")or die("Error updating data request");
}
header("location:index.php");
?>