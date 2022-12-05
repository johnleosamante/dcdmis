<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO tbl_request VALUES(NULL,'".$_POST['request_for']."','".$_POST['date_apply']."','".$_POST['No_of_day']."','Pending Request....','".$_POST['req_from']."','".$_POST['req_to']."','".$_SESSION['EmpID']."')")or die ("Request data error");
header("location:request_for_leave.php");
?>