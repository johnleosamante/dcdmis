<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_list_of_module_activity WHERE ModuleCode='".$_GET['id']."' LIMIT 1");
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($_SESSION['SubCode'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("uploadfile")));
?>