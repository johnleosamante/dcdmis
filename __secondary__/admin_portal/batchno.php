<?php
session_start();
echo $_GET['id'];
$_SESSION['Batchno']=$_GET['id'];
?>