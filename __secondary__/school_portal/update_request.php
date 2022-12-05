<?php
session_start();
include("../vendor/jquery/function.php");

mysqli_query($con,"UPDATE tbl_request SET Request_status='For SDS Approval.' WHERE No='".$_GET['code']."' AND Emp_ID='".$_GET['TIN']."'")or die("Error updating data request");

header("location:index.php");
?>