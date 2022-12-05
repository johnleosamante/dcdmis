<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO tbl_school VALUES ('".$_POST['school_id']."','".$_POST['school_name']."','".$_POST['school_address']."','".$_POST['principal']."','".$_POST['Category']."','".$_POST['District']."','0','".$_POST['abrave']."')")or die ("School record Error entry");
header("location:schools.php");
?>