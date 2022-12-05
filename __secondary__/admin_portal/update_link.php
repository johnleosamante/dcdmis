<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_pisa_questions SET question_link='".$_POST['location']."' WHERE SubCode='".$_SESSION['SubCode']."' AND QNo ='".$_SESSION['QNo']."'AND BatchNo='".$_SESSION['Batchno']."'LIMIT 1");
?>