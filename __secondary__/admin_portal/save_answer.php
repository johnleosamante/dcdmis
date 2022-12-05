<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_pisa_questions SET Answer_keys='".$_POST['answer']."' WHERE QNo = '".$_SESSION['QNo']."' AND SubCode='".$_SESSION['SubCode']."' AND BatchNo='".$_SESSION['Batchno']."' LIMIT 1");

?>