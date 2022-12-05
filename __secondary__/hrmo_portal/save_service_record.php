<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO tbl_service_records VALUES(NULL,'".$_POST['date_from']."','".$_POST['date_to']."','".$_POST['position']."','".$_POST['work_status']."','".$_POST['salary']."','".$_POST['school']."','".$_POST['branch']."','".$_POST['pay_status']."','".$_POST['separation']."','".$_SESSION['per_sr']."')");
header("location:service_record.php");
?>