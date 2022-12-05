<?php
session_start();
include("../vendor/jquery/function.php");
if(isset($_POST["Import"]))
//if ($_SERVER_REQUEST['METHOD']=='POST')	
{
	 echo $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
            $sql = "INSERT into tbl_employee VALUES ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','','$emapData[4]','$emapData[5]','$emapData[6]','','$emapData[7]','','$emapData[8]','','','','','','$emapData[9]','../images/user.png','$emapData[19]','Active')";
			mysqli_query($con,$sql);
			
			mysqli_query($con,"INSERT into tbl_station values(NULL,'$emapData[14]','$emapData[16]','$emapData[18]','$emapData[20]','$emapData[21]','43','$emapData[0]')")or die ("Error Station");


		mysqli_query($con,"INSERT into psipop values (NULL,'$emapData[10]','$emapData[11]','$emapData[12]','$emapData[13]','','','','','$emapData[19]','$emapData[17]','$emapData[14]','$emapData[15]')");
		
		/*mysql_query("INSERT INTO tbl_deployment_history VALUES(NULL,'".$_POST['DOA']."','".$_POST['school']."','".$_POST['position']."','$noOfYears','".$_POST['Employee_ID']."')")or die ("Error deploment History");
		mysql_query("INSERT INTO tbl_step_increment VALUES(NULL,'".$stat."','".$_POST['stepno']."','0','".$_POST['Employee_ID']."')")or die ("Step Error");					
		mysql_query("INSERT INTO tbl_employment_summary VALUES(NULL,'".$_POST['DOA']."','".$_POST['position']."','".$_POST['school']."','".$_POST['stepno']."','".$_POST['Employee_ID']."')")or die ("Error Employment History");					
  			*/
        }
        fclose($file);
		echo '<script>
				{
					alert("Successfully Uploaded!");
					window.location.href="view_profile.php?link=13b714fad9eca2a00fe69ce8ce03cba1c7e08527"
				}
			</script>';
		}
    else{
        echo 'Invalid File:Please Upload CSV File';
}
}
?>