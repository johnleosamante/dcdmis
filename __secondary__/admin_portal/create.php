<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_employee SET tbl_employee.Emp_Email='".$_POST['uname']."',Emp_Status='Active' WHERE tbl_employee.Emp_ID='".$_SESSION['per_id']."'")or die ("error update Teacher");
$pass=md5($_POST['upass']);
if ($_POST['position']=="ICT COORDINATOR"){
mysqli_query($con,"INSERT INTO tbl_teacher_account VALUES(NULL,'".$_POST['uname']."','".$pass."','Offline','Default','".date('Y/m/d H:i:s')."')");
mysqli_query($con,"INSERT INTO tbl_user VALUES('".$_SESSION['per_id']."','".$_POST['uname']."','".$pass."','".$_POST['position']."','".$_SESSION['SchoolID']."','Default','".date('Y/m/d H:i:s')."','Offline','')")or die ("error users for ICT Coordinator");	
}elseif ($_POST['position']=="TEACHER"){
	mysqli_query($con,"INSERT INTO tbl_teacher_account VALUES(NULL,'".$_POST['uname']."','".$pass."','Offline','Default','".date('Y/m/d H:i:s')."')")or die ("error Teacher");

	}else{
		
		mysqli_query($con,"INSERT INTO tbl_user VALUES('".$_SESSION['per_id']."','".$_POST['uname']."','".$pass."','Administrator','".$_POST['position']."','Default','".date('Y/m/d H:i:s')."','Offline','')")or die ("error users");	
		mysqli_query($con,"INSERT INTO tbl_teacher_account VALUES(NULL,'".$_POST['uname']."','".$pass."','Offline','Default','".date('Y/m/d H:i:s')."')")or die ("error Teacher");

	}

?>
<script>
{
	alert("Successfully Account Created!!");
	window.location.href='./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=cGVyc29ubmVs';
}
</script>