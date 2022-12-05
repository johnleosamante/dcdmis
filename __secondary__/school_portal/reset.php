<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$pass=md5($_POST['upass']);
mysqli_query($con,"UPDATE tbl_employee SET Emp_Email = '".$_POST['uname']."' WHERE Emp_ID='".$_SESSION['per_id']."'");					
mysqli_query($con,"UPDATE tbl_teacher_account SET tbl_teacher_account.Teacher_Password='".$pass."',Pass_status='Default',tbl_teacher_account.Teacher_TIN='".$_POST['uname']."' WHERE tbl_teacher_account.Teacher_TIN='".$_GET['email']."'");


	echo '<script>
{
	alert("Please Activate your Account using DepEd Email.");
	window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("personnel")).'";
}
</script>';

?>
