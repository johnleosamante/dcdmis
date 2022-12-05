<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"UPDATE tbl_employee SET Emp_Status='Active' WHERE Emp_ID='".$_SESSION['per_id']."' LIMIT 1");
?>
<script>
{
	alert("Successfully Confirm!!!");
	window.location.href='./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=cmVnaXN0ZXJlZA%3D%3D';
}
</script>