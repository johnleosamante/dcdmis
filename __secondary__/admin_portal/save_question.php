<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$data=$_POST['QA'];
$data=str_replace("'","\'",$data);					
$query=mysqli_query($con,"SELECT * FROM tbl_assessment_rat_questionaires WHERE QNumber='".$_POST['NO']."' AND SubCode='".$_SESSION['SubCode']."'");
if (mysqli_num_rows($query)==1)
{
mysqli_query($con,"UPDATE tbl_assessment_rat_questionaires SET Questionnairs ='".$data."' WHERE QNumber='".$_POST['NO']."' AND SubCode='".$_SESSION['SubCode']."'");	
}else{	
mysqli_query($con,"INSERT INTO tbl_assessment_rat_questionaires VALUES(NULL,'".$_POST['NO']."','".$data."','-','".$_SESSION['SubCode']."','0','')");
}						

?>	
				
					
	