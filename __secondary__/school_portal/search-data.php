<?php
session_start();
$_SESSION['week']=$_POST['week'];
$_SESSION['quarter']=$_POST['quarter'];
header("location:lrmds-report.php?link=10a638b057cff7770c37024121ccb27e2f18f791");
?>