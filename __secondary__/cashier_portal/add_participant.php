<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
}
mysqli_query($con,"INSERT INTO tbl_seminar_participant VALUES(NULL,'".$_SESSION['TrainingCode']."','0','".$code."')");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("new_participants")));
?>
