<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$pass=md5($_POST['upass']);	
mysqli_query($con,"UPDATE tbl_employee SET Emp_Email = '".$_POST['uname']."' WHERE Emp_ID='".$_SESSION['per_id']."'")or die("Error employee");					
mysqli_query($con,"UPDATE tbl_teacher_account SET tbl_teacher_account.Teacher_Password='".$pass."',Pass_status='Default',tbl_teacher_account.Teacher_TIN='".$_POST['uname']."' WHERE tbl_teacher_account.Teacher_TIN='".$_GET['email']."'")or die("Error Teacher account");
$rec=mysqli_query($con,"SELECT * FROM tbl_user WHERE usercode='".$_SESSION['per_id']."'") or die("Error user query");
	if (mysqli_num_rows($rec)==1)
	{
		if ($_POST['position']=="ICT COORDINATOR"){
	 	  mysqli_query($con,"UPDATE tbl_user SET tbl_user.password='".$pass."',position='".$_POST['position']."',Status='Default' WHERE usercode='".$_SESSION['per_id']."'")or die ("Error updating password");
		}elseif ($_POST['position']=="TEACHER"){
			mysqli_query($con,"UPDATE tbl_teacher_account SET tbl_teacher_account.Teacher_Password='".$pass."',Pass_status='Default',tbl_teacher_account.Teacher_TIN='".$_POST['uname']."' WHERE tbl_teacher_account.Teacher_TIN='".$_GET['email']."'")or die("Error Teacher account");
		}else{
			 mysqli_query($con,"UPDATE tbl_user SET tbl_user.password='".$pass."',Station='".$_POST['position']."',Status='Default' WHERE usercode='".$_SESSION['per_id']."'")or die ("Error updating password");
		}
	}else{
		if ($_POST['position']=="ICT COORDINATOR"){
		mysqli_query($con,"INSERT INTO tbl_user VALUES('".$_SESSION['per_id']."','".$_GET['email']."','".$pass."','".$_POST['position']."','".$_SESSION['SchoolID']."','Default','".date('Y/m/d H:i:s')."','Offline','school_portal')")or die ("error users");	
		}elseif ($_POST['position']=="TEACHER"){
		$query=mysqli_query($con,"SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='".$_POST['uname']."'");
		if (mysqli_num_rows($query)==0)
		{
			mysqli_query($con,"INSERT INTO tbl_teacher_account VALUES(NULL,'".$_POST['uname']."','".$pass."','Offline','Default','".date('Y/m/d H:i:s')."')")or die ("error Teacher");
		}
		}else{
			 mysqli_query($con,"INSERT INTO tbl_user VALUES('".$_SESSION['per_id']."','".$_GET['email']."','".$pass."','Administrator','".$_POST['position']."','Default','".date('Y/m/d H:i:s')."','Offline','')")or die ("error Teacher");
		}
	}
?>	
<script>
{
	alert("Please Activate your Account using DepEd Email.");
	window.location.href='./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=cGVyc29ubmVs';
}
</script>