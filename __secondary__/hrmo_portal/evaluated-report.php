<?php
session_start();
include("../vendor/jquery/function.php");
		$no=0;
		$result=mysqli_query($con,"SELECT * FROM tbl_erf_requirements ORDER BY ERF_Code Asc");
		while ($row=mysqli_fetch_array($result))
		{
			$no++;
			if (isset($_POST[$no]))
			{
				$record=mysqli_query($con,"SELECT * FROM tbl_applicant_requirement WHERE ERF_Code='".$_POST[$no]."' AND Transaction_Code='".$_SESSION['TCode']."'");	
				if (mysqli_num_rows($record)==0)
				{
					mysqli_query($con,"INSERT INTO tbl_applicant_requirement VALUES(NULL,'".$_POST[$no]."','".$_SESSION['TCode']."')");
				}
			}	
		}
mysqli_query($con,"UPDATE tbl_online_application SET Transaction_status='For SDS Approval',Transaction_office='SDS' WHERE Transaction_number ='".$_SESSION['TCode']."' LIMIT 1");		
mysqli_query($con,"INSERT INTO tbl_application_log VALUES(NULL,'".date("Y-m-d")."','".$_SESSION['Per_Name']."','Evaluation and Assessment','HRMO','".$_SESSION['TCode']."')")or die ("Error Log");
		
?>
<script>
{
	alert("Successfully Evaluated and Assessment!!");
	window.location.href="erf.php";
}
</script>