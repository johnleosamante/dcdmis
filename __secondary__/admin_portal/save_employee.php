<?php
session_start();
include("../vendor/jquery/function.php");
$age=date('Y')- $_POST['Year'];

$emapData1= $_POST['Employee_ID'];

$emapData2= $_POST['LName'];
$emapData3= $_POST['FName'];
$emapData4= $_POST['MName'];
$emapData5= $_POST['extension'];
$emapData6= $_POST['month'];
$emapData7=$_POST['day'];
$emapData8=$_POST['Year'];
$emapData9= $_POST['birth_place'];
$emapData10= $_POST['sex'];
$emapData11= $_POST['address'];
$emapData12=$_POST['civil_status'];
$emapData13= $_POST['Citizen'];
$emapData14=$_POST['height'];
$emapData15= $_POST['wieght'];
$emapData16=$_POST['blood_type'];
$emapData17= $_POST['CellNo'];
$emapData18= $_POST['email'];
$emapData19= "../images/user.png";
$emapData20= $_POST['TIN'];
$emapData21= "Active";


//Station
$emapData22="NULL";
$emapData23=$_POST['DOA'];
$emapData24=$_POST['position'];
$emapData25= $_POST['school'];
$emapData26=$_POST['Category'];
$emapData27= $_POST['office'];
$emapData28= $age;

$sql = "INSERT into tbl_employee values ('$emapData1','$emapData2','$emapData3','$emapData4','$emapData5','$emapData6','$emapData7','$emapData8','$emapData9','$emapData10','$emapData11','$emapData12','$emapData13','$emapData14','$emapData15','$emapData16','$emapData17','$emapData18','$emapData19','$emapData20','$emapData21')";
mysqli_query($con,$sql)or die ("Error Employee");

$sql = "INSERT into tbl_station values ('$emapData22','$emapData23','$emapData24','$emapData25','$emapData26','$emapData27','$emapData28','$emapData1')";
mysqli_query($con,$sql)or die ("Error Station");

mysqli_query($con,"INSERT INTO tbl_deployment_history VALUES(NULL,'".$_POST['DOA']."','".$_POST['school']."','".$_POST['position']."','".$_POST['Employee_ID']."')");
	
header('Location: personel.php');
  
?>