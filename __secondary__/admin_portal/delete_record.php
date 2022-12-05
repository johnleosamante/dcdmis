<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_assessment_rat WHERE LRN='".$_GET['re']."' LIMIT 1");
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_examinee")));
?>
