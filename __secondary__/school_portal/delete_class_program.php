<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_subject_load WHERE SubCode='".$_GET['SubCode']."' AND School_Year='".$_SESSION['year']."' AND Emp_ID='".$_GET['EmpID']."' LIMIT 1");
mysqli_query($con,"DELETE FROM class_program WHERE No='".$_GET['id']."' AND SchoolYear='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' LIMIT 1");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($_SESSION['Grade'])).'&Code='.urlencode(base64_encode($_SESSION['sec_id'])).'&v='.urlencode(base64_encode("subject_by_section")));
?>