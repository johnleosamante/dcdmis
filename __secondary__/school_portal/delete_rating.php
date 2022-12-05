<?php
 session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_ipcrf_consolidated WHERE No='".$_GET['id']."' LIMIT 1");
header('location:./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&No='.urlencode(base64_encode($_SESSION['No'])).'&v='.urlencode(base64_encode("view_esst_consol")));
?>