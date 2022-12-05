<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_station SET Emp_Position='".$_POST['newPost']."' WHERE Emp_ID='".$_SESSION['per_id']."' LIMIT 1");
header("location:personnel.php?link=".sha1("Deped pagadian city division information management system"));
?>

