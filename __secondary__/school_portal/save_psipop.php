<?php
session_start();
include("../vendor/jquery/function.php");

if(isset($_POST["save"]))
{   
 $data=mysqli_query($con,"SELECT * FROM psipop WHERE psipop.TIN='".$_SESSION['myTIN']."'");
 if (mysqli_num_rows($data)==0) 
 {
	$stat=mb_strimwidth($_POST['DPromoted'],0,4);   
        $sql = "INSERT into psipop values (NULL,'".$_POST['Item_Number']."','".$_POST['ASalary']."','".$_POST['Actual']."','".$_POST['Step']."','".$_POST['Code']."','".$_POST['PType']."','".$_POST['PLevel']."','".$_POST['PAttribute']."','".$_POST['TIN']."','".$_POST['JStatus']."','".$_POST['DPromoted']."','".$_POST['PElegibility']."')";
		mysqli_query($con,$sql)or die("Error PSIPOP");
	mysqli_query($con,"INSERT INTO tbl_step_increment VALUES(NULL,'".$stat."','".$_POST['Step']."','0','".$_GET['emp']."')")or die ("Step Error");					
 }else{
	 mysqli_query($con,"UPDATE psipop SET Item_Number='".$_POST['Item_Number']."',Autorized='".$_POST['ASalary']."',Actual='".$_POST['Actual']."',Step='".$_POST['Step']."',Code='".$_POST['Code']."',Type='".$_POST['PType']."',Level='".$_POST['PLevel']."',Attribute='".$_POST['PAttribute']."',TIN='".$_POST['TIN']."',Job_status='".$_POST['JStatus']."',Date_promoted='".$_POST['DPromoted']."',Elegibility='".$_POST['PElegibility']."' WHERE psipop.TIN='".$_SESSION['myTIN']."'")or die ("Error Update");
 }	
	header('location: personnel.php');
	

}
?>