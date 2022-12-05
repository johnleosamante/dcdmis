<?php
session_start();
require("../vendor/jquery/function.php");
$pass=md5($_GET['password']);

mysqli_query($con,"UPDATE tbl_student_user SET password='".$pass."' WHERE username='".$_GET['password']."' LIMIT 1");
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("learner_account")));
?>