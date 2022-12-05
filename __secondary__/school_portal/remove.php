<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_shs_report WHERE SubNo='".$_GET['id']."' AND SpecCode='".$_SESSION['SpCode']."' AND SchoolID ='".$_SESSION['school_id']."' AND WeekNo ='".$_SESSION['week']."' AND QuarterNo ='".$_SESSION['quarter']."'LIMIT 1");
mysqli_query($con,"DELETE FROM tbl_shs_subject WHERE SubNo='".$_GET['id']."' AND SpCode='".$_SESSION['SpCode']."' AND SchoolID ='".$_SESSION['school_id']."' AND Grade ='".$_SESSION['SubGrade']."' AND Semester='".$_SESSION['Sem']."' LIMIT 1");
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&g='.urlencode(base64_encode($_SESSION['SubGrade'])).'&code='.urlencode(base64_encode($_SESSION['SpCode'])).'&v='.urlencode(base64_encode("view_qualification")));
?>