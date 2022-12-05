<?php
 session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_sep_annexa10 WHERE CardCode='".$_GET['id']."' LIMIT 1");
header("location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=QW5uZXhBMTA%3D");
?>