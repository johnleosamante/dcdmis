<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM reference WHERE reference.Emp_ID='".$_SESSION['EmpID']."' AND reference.No ='".$_GET['id']."' LIMIT 1");
echo '<script>
		{
			alert("Successfully Deleted!!");
			window.location.href="pds.php?link=534eeb59f82dc387a472c69e8febbd4e4b95bc69";
		}
	</script>';										
?>