<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
if ($code=='Closed')
{
mysqli_query($con,"UPDATE tbl_assessment_rat_subject SET Status = 'Opened' WHERE RATSubCode='".$_SESSION['SubCode']."' AND Grade_Level='".$_SESSION['GLevel']."' LIMIT 1");
}else{
mysqli_query($con,"UPDATE tbl_assessment_rat_subject SET Status = 'Closed' WHERE RATSubCode='".$_SESSION['SubCode']."' AND Grade_Level='".$_SESSION['GLevel']."' LIMIT 1");
}
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($_SESSION['SubCode'])).'&GLevel='.urlencode(base64_encode($_SESSION['GLevel'])).'&v='.urlencode(base64_encode("Questionnairs")));
?>