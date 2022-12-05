<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"INSERT tbl_payroll_salary VALUES('".date("yds")."','".$_GET['id']."','0','0','0','0','".$_SESSION['code']."')");
$result=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_GET['id']."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
echo $row['Emp_LName'].', '.$row['Emp_FName'].' Successfully Added';
?>