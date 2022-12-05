<?php
session_start();
include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
mysqli_query($con,"DELETE FROM tbl_school_participant WHERE No='".$_GET['code']."' LIMIT 1");

?>
<script>
{
alert("Successfully Deleted!");
window.location.href='list_of_activity.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c';

}
</script>