<?php
session_start();
$_SESSION['per_id']=$_GET['id'];
header("location:view_personnel.php");
?>