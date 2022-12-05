<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_qualification_by_school WHERE QualNo='".$_GET['Code']."'LIMIT 1");
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("track")));
?>