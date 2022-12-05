<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_list_of_module_activity SET Module_location='' WHERE ModuleCode ='".$_SESSION['Access']."' LIMIT 1");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($_SESSION['Access'])).'&Item='.urlencode(base64_encode("1")).'&v='.urlencode(base64_encode("addreadingmaterial")));

?>