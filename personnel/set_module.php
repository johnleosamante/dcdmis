<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$state=$_GET[$key]=base64_decode(urldecode($data));	
}

if ($state=="Open")
{
  mysqli_query($con,"UPDATE tbl_module_information SET Module_status='Close' WHERE ModuleSubCode='".$_SESSION['SubCode']."' AND ModuleQuarter='".$_SESSION['Quarter']."' AND ModuleSY ='".$_SESSION['year']."' AND ModuleTitle='".$_SESSION['Access']."' AND ModuleSecCode='".$_SESSION['SecCode']."' LIMIT 1");	
}else{
  mysqli_query($con,"UPDATE tbl_module_information SET Module_status='Open' WHERE ModuleSubCode='".$_SESSION['SubCode']."' AND ModuleQuarter='".$_SESSION['Quarter']."' AND ModuleSY ='".$_SESSION['year']."' AND ModuleTitle='".$_SESSION['Access']."' AND ModuleSecCode='".$_SESSION['SecCode']."' LIMIT 1");	

}

echo '<script>{
alert("Successfully Changed!!!!");
}</script>';
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($_SESSION['Access'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("written_work_activity")));
?>