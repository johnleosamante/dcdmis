<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_request  WHERE No='".$_GET['code']."' AND Emp_ID='".$_GET['TIN']."' LIMIT 1")or die("Error updating data request");
header("location:index.php");
?>