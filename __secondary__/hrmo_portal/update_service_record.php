<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_service_records SET tbl_service_records.date_to='".$_POST['date_to']."' WHERE tbl_service_records.Emp_ID='".$_SESSION['per_sr']."' AND tbl_service_records.No='".$_SESSION['Num']."' LIMIT 1");
header("location:service_record.php");
?>