<?php
session_start();
include("../vendor/jquery/function.php");
$str=sha1("deped-pagadian management information system");
if ($_GET['district']<>"")
{
$_SESSION['dist']=$_GET['district'];
header("location:view_details.php");
}elseif ($_POST['TCode']<>"")
{
	
	$_SESSION['TCode']=$_POST['TCode'];
	header("location:view_information.php?link=".$str);
	
	}
?>