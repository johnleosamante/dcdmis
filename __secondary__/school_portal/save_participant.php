<?php
session_start();
include("../vendor/jquery/function.php");
$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_station.Emp_Station ='".$_SESSION['school_id']."'ORDER BY Emp_LName Asc")or die ("Retirees Information error");
$no=0;
while($row=mysqli_fetch_array($myinfo))
{
	$no++;
	if ($_POST['Part-'.$no]<>"")
	{
	 mysqli_query($con,"INSERT INTO tbl_seminar_participant VALUES(NULL,'".$_SESSION['TCode']."','".$_POST['Part-'.$no]."')");
	mysqli_query($con,"INSERT INTO tbl_messages VALUES (NULL,'ICT','".$_POST['Part-'.$no]."','".$_SESSION['TCode']."','".date('Y-m-d')."','Unread','Training')");
	
	}
}
header("location:my_message.php");	
?>