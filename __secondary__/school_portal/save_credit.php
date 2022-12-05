<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO tbl_leave_credits VALUES(NULL,'".$_POST['dcreate']."','".$_POST['legal']."','".$_POST['leave_type']."','".$_POST['days']."','".$_POST['service']."','".$_SESSION['credit']."')");
header("location:leave_credit.php");
?>