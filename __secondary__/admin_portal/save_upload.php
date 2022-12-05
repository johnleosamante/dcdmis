<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$no=0;
$newpath=$_SESSION['pathlocation'].'/'.$_POST['filename'];
mysqli_query($con,"UPDATE tbl_list_of_module_activity SET Module_location='".$newpath."' WHERE ModuleCode='".$_SESSION['Access']."' AND Grade_Level ='".$_SESSION['Grade_Level']."' AND SubCode='".$_SESSION['SubCode']."' LIMIT 1");

?>