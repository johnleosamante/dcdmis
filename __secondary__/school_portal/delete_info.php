<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$str=sha1("Pagadian City Division Data Management Information System");
foreach ($_GET as $key => $data)
			{
			$lrn=$_GET[$key]=base64_decode(urldecode($data));
				
			}
mysqli_query($con,"DELETE FROM tbl_registration  WHERE lrn='".$lrn."' AND school_year='".$_SESSION['year']."' LIMIT 1")or die("Error updating data request");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("registered")));
?>