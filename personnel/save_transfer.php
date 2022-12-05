<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_station INNER JOIN tbl_school ON tbl_station.Emp_Station =tbl_school.SchoolID  WHERE tbl_station.Emp_ID ='".$_SESSION['EmpID']."'");
$row=mysqli_fetch_assoc($result);

mysqli_query($con,"INSERT INTO tbl_transfer_data VALUES (NULL,'".$row['SchoolName']."','".$_POST['trans_to']."','".$_POST['reason']."','".$_SESSION['EmpID']."','Pending Request...')")or die ("Transfer data Error");
header("location:request_for_leave.php");
?>