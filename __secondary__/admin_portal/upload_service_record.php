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
            $sql = "INSERT into tbl_service_records VALUES (NULL,'$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$emapData[8]','". $_SESSION['EmpID']."')";
			mysqli_query($con,$sql);
					
			
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