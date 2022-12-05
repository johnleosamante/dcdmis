 <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"INSERT INTO tbl_registration VALUES(NULL,'".$_SESSION['search_LRN']."','".$_SESSION['year']."','".date('Y-m-d')."','".$_SESSION['grade']."','Registered','".$_SESSION['SchoolID']."','".$_POST['YLevelStatus']."','".$_POST['GWA']."')");
	echo '<script type="text/javascript">
		{
			alert("Successfully Enrolled!!");
			window.location.href="my_subject.php?link=534eeb59f82dc387a472c69e8febbd4e4b95bc69";
							
		}
		</script>';	
?>