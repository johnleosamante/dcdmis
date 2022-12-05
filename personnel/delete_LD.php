<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM learning_and_development WHERE learning_and_development.Emp_ID='".$_SESSION['EmpID']."' AND learning_and_development.No ='".$_GET['id']."' LIMIT 1");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("pds")));
?>