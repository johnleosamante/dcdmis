<?php
session_start();
$_SESSION['credit']=$_GET['id'];
header("location:leave_credit.php");
?>