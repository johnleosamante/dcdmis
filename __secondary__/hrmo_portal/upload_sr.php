<?php
session_start();
include("../vendor/jquery/function.php");
//if(isset($_POST["Import"]))
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	 echo $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
          while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
			{
			
			$sql = "INSERT into tbl_service_records values (NULL,'$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$emapData[8]','".$_SESSION['per_sr']."')";
			mysqli_query($con,$sql)or die ("Error Employee");

			 }			
						
		fclose($file);
        header('location:service_record.php');

    }
else{
        echo 'Invalid File:Please Upload CSV File';
}
}
?>