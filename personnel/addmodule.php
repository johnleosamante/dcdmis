<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
ini_set('memory_limit', '1024M');
$str=sha1("Deped Pagadian City data Management Information System");
if($_SESSION['EmpID']=="")
{
	header("location:login/?".$str.$str.$str);
}
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
}
$query=mysqli_query($con,"SELECT * FROM tbl_module_information WHERE ModuleTitle='".$url."' AND ModuleQuarter='".$_SESSION['Quarter']."' AND ModuleSubCode='".$_SESSION['SubCode']."' AND ModuleSY='".$_SESSION['year']."' AND ModuleSecCode='".$_SESSION['SecCode']."'");
if (mysqli_num_rows($query)==0)
{
mysqli_query($con,"INSERT INTO tbl_module_information VALUES(NULL,'".$url."','".$_SESSION['Quarter']."','".$_SESSION['SubCode']."','".$_SESSION['year']."','".$_SESSION['SecCode']."','Closed')");
}
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($_SESSION['Grade'])).'&SubNo='.urlencode(base64_encode($_SESSION['SubCode'])).'&SecCode='.urlencode(base64_encode($_SESSION['SecCode'])).'&v='.urlencode(base64_encode("class_list")));
?>