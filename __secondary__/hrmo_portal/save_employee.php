<?php
session_start();
include("../vendor/jquery/function.php");
if (isset($_POST['save']))
{
$age=date('Y')- $_POST['Year'];

$emapData1= $_POST['Employee_ID'];
$emapData2= $_POST['LName'];
$emapData3= $_POST['FName'];
$emapData4= $_POST['MName'];
$emapData5= $_POST['extension'];
$emapData6= $_POST['month'];
$emapData7=$_POST['day'];
$emapData8=$_POST['Year'];
$emapData9="";
$emapData10= $_POST['sex'];
$emapData11= "";
$emapData12=$_POST['civil_status'];
$emapData13= "";
$emapData14="";
$emapData15= "";
$emapData16="";
$emapData17= "";
$emapData18= $_POST['email'];
$emapData19= "../images/user.png";
$emapData20= $_POST['TIN'];
$emapData21= "Active";



//psipop
$emapData29=$_POST['ItemNo'];
$emapData30=$_POST['AutoSal'];
$emapData31=$_POST['Actual'];
$emapData32=$_POST['stepno'];
$emapData33="";
$emapData34="";
$emapData35="";
$emapData36="";
$emapData37=$_POST['TIN'];
$emapData38=$_POST['job_status'];
$emapData39=$_POST['DOA'];
$emapData40=$_POST['elegibility'];
$stat=mb_strimwidth($_POST['DOA'],0,4); 
 $noOfYears=date('Y')- $stat;
$sql = "INSERT into tbl_employee values ('$emapData1','$emapData2','$emapData3','$emapData4','$emapData5','$emapData6','$emapData7','$emapData8','$emapData9','$emapData10','$emapData11','$emapData12','$emapData13','$emapData14','$emapData15','$emapData16','$emapData17','$emapData18','$emapData19','$emapData20','$emapData21','-')";
mysqli_query($con,$sql)or die ("Error Employee");

mysqli_query($con,"INSERT into tbl_station values(NULL,'".$_POST['DOA']."','".$_POST['position']."','".$_POST['school']."','".$_POST['Category']."','".$_POST['office']."','$age','".$_POST['Employee_ID']."')")or die ("Error Station");


$sql = "INSERT into psipop values (NULL,'$emapData29','$emapData30','$emapData31','$emapData32','$emapData33','$emapData34','$emapData35','$emapData36','$emapData37','$emapData38','$emapData39','$emapData40')";
mysqli_query($con,$sql)or die ("Error Psipop");

mysqli_query($con,"INSERT INTO tbl_deployment_history VALUES(NULL,'".$_POST['DOA']."','".$_POST['school']."','".$_POST['position']."','$noOfYears','".$_POST['Employee_ID']."')")or die ("Error deploment History");
mysqli_query($con,"INSERT INTO tbl_step_increment VALUES(NULL,'".$stat."','".$_POST['stepno']."','0','".$_POST['Employee_ID']."')")or die ("Step Error");					
  
}
echo '<script>
	{
		alert("Successfully Save!!");
		window.location.href="personnel.php??link=10a638b057cff7770c37024121ccb27e2f18f791";
	}
	</script>';	


?>