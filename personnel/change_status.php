<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
if ($_GET['status']=='Opened')
{
mysqli_query($con,"UPDATE tbl_written_work_set_activity SET Activity_status = 'Closed' WHERE QCode='".$_GET['code']."' LIMIT 1");	
}else{
mysqli_query($con,"UPDATE tbl_written_work_set_activity SET Activity_status = 'Opened' WHERE QCode='".$_GET['code']."' LIMIT 1");
}
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&m='.urlencode(base64_encode($_GET['code'])).'&ItemNo='.urlencode(base64_encode($_GET['Item'])).'&Item='.urlencode(base64_encode($_GET['ItemNo'])).'&Type='.urlencode(base64_encode($_SESSION['ActType'])).'&Name='.urlencode(base64_encode($_SESSION['Name'])).'&v='.urlencode(base64_encode("written_work_set_work")));
?>