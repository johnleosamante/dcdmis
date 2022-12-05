<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO voluntary_work VALUES (NULL,'".$_POST['Organization']."','".$_POST['From']."','".$_POST['To']."','".$_POST['Hours']."','".$_POST['Position']."','".$_SESSION['EmpID']."')")or die ("Save family Insert Error");
header("location:pds.php");
?>