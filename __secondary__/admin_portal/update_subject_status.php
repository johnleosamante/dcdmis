<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_subject WHERE Grade_Level='".$_POST['grade_level']."' AND Exam_Status='".$_SESSION['rat_status']."'");
$row=mysqli_fetch_assoc($result);
if ($row['Status']=='Closed')
{
	mysqli_query($con,"UPDATE tbl_assessment_rat_subject SET Status='Opened' WHERE Grade_Level='".$_POST['grade_level']."' AND Exam_Status='".$_SESSION['rat_status']."'");
}elseif($row['Status']=='Opened')
{
	mysqli_query($con,"UPDATE tbl_assessment_rat_subject SET Status='Closed' WHERE Grade_Level='".$_POST['grade_level']."' AND Exam_Status='".$_SESSION['rat_status']."'");
}
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_subject")));
?>