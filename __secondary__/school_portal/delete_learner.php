<?php
session_start();
//ini_set('session.save_path', 'tmp');  
require("../vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$l=$_GET[$key]=base64_decode(urldecode($data));
}
if ($l==11 || $l==11)
{
	if ($_SESSION['Sem']=='First Semester')
	{
		mysqli_query($con,"DELETE FROM first_semester WHERE lrn ='".$_GET['id']."' AND Grade='".$l."' LIMIT 1");
	}elseif ($_SESSION['Sem']=='Second Semester')
	{
		mysqli_query($con,"DELETE FROM second_semester WHERE lrn ='".$_GET['id']."' AND Grade='".$l."' LIMIT 1");	
	}
}else{
	mysqli_query($con,"DELETE FROM tbl_learners WHERE lrn ='".$_GET['id']."' AND Grade='".$l."' LIMIT 1");
}
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")));
?>