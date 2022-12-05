<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO tbl_employment_summary VALUES (NULL,'".date('Y-m-d')."','".$_POST['position']."','".$_POST['state']."','".$_POST['to_step']."','".$_POST['salary']."','".$_SESSION['StepID']."')");
mysqli_query($con,"UPDATE tbl_step_increment SET Date_last_step='".date('Y')."',Step_No='".$_POST['to_step']."',No_of_year='0' WHERE Emp_ID='".$_SESSION['StepID']."'");
header("location:steps.php");
?>