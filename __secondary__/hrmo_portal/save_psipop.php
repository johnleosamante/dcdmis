<?php
session_start();
include("../vendor/jquery/function.php");

if(isset($_POST["save"]))
{   
	 mysqli_query($con,"UPDATE psipop SET Code='".$_POST['Code']."',Type='".$_POST['PType']."',Level='".$_POST['PLevel']."',Attribute='".$_POST['PAttribute']."' WHERE psipop.TIN='".$_SESSION['myTIN']."'")or die ("Error Update");
	header('location: personnel.php');
}
?>