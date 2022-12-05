<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_school SET Incharg_ID='".$_POST['newprin']."' WHERE SchoolID='".$_SESSION['myID']."' LIMIT 1");
echo '<script>
		{
		alert("Successfully Assign New Incharge!!");
		window.location.href="list_of_school.php";
		}</script>';
?>