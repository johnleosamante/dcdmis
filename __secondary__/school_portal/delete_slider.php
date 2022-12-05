<?php
session_start();
include("../vendor/jquery/function.php");
$str=sha1("Pagadian City Division Data Management Information System");

mysqli_query($con,"DELETE FROM wp_slider  WHERE No='".$lrn."' LIMIT 1");
header('./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("slider")));
?>