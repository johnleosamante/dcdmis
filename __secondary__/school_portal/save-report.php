<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
$myreport=mysqli_query($con,"SELECT * FROM tbl_shs_report WHERE tbl_shs_report.SubCode='".$_GET['SubNo']."' AND tbl_shs_report.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_report.WeekNo='".$_SESSION['week']."' AND tbl_shs_report.QuarterNo='".$_SESSION['quarter']."' AND tbl_shs_report.SpecCode='".$_SESSION['SpCode']."'");					   
	if(mysqli_num_rows($myreport)==0)
	{
		date_default_timezone_set("Asia/Manila");
		mysqli_query($con,"INSERT INTO tbl_shs_report VALUES(NULL,'".$_SESSION['SubGrade']."','0','".$_GET['SubNo']."','".$_POST['no_of_module']."','".$_SESSION['school_id']."','".date('Y-m-d')."','".$_SESSION['week']."','-','".$_SESSION['SubType']."','".$_SESSION['quarter']."','".$_SESSION['SpCode']."')");
									
	}else{
			mysqli_query($con,"UPDATE tbl_shs_report SET No_of_copies='".$_POST['no_of_module']."' WHERE SubCode='".$_GET['SubNo']."' AND GradeLevel='".$_SESSION['SubGrade']."' AND SchoolID='".$_SESSION['school_id']."' AND WeekNo='".$_SESSION['week']."' AND QuarterNo='".$_SESSION['quarter']."' AND SpecCode='".$_SESSION['SpCode']."' LIMIT 1");
									
	}
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&g='.urlencode(base64_encode($_SESSION['SubGrade'])).'&code='.urlencode(base64_encode($_SESSION['SpCode'])).'&v='.urlencode(base64_encode("view_qualification")));	
?>