<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM tbl_employee WHERE Emp_ID='".$_GET['id']."' LIMIT 1");
mysqli_query($con,"DELETE FROM tbl_station WHERE Emp_ID='".$_GET['id']."' LIMIT 1");
?>
<script>
{
	alert("Successfully deleted");
	window.location.href='./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=cmVnaXN0ZXJlZA%3D%3D';
}
</script>