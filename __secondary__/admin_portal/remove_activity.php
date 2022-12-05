<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$id=$_GET[$key]=base64_decode(urldecode($data));
	
}
mysqli_query($con,"DELETE FROM tbl_written_work_set_activity WHERE QCode='".$id."' LIMIT 1");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($_SESSION['Access'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("addreadingmaterial")));
?>