<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_downloads WHERE FileCode='".$_GET['id']."' LIMIT 1");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("downloads")))
?>