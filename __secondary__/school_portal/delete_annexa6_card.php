<?php
 session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_sep_annexa6_card WHERE CardNo='".$_GET['code']."' LIMIT 1");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($_SESSION['CardCode'])).'&v='.urlencode(base64_encode("view_annexA6")));
?>