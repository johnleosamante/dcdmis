<?php
session_start();
include("../vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
mysqli_query($con,"DELETE FROM tbl_assessment_rat_questionaires WHERE tbl_assessment_rat_questionaires.QNumber='".$code."' AND tbl_assessment_rat_questionaires.SubCode='".$_SESSION['SubCode']."' LIMIT 1");
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($_SESSION['SubCode'])).'&GLevel='.urlencode(base64_encode($_SESSION['GLevel'])).'&v='.urlencode(base64_encode("Questionnairs")));

?>