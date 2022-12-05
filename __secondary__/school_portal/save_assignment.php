<?php
session_start();
include("../vendor/jquery/function.php");

$year=date("Y") - mb_strimwidth($_POST['date_order'],0,4);
$res=mysqli_query($con,"SELECT * FROM tbl_user WHERE usercode ='".$_SESSION['per_id']."' LIMIT 1");
if (mysqli_num_rows($res)==1)
{
	mysqli_query($con,"UPDATE tbl_user SET Station='".$_POST['station']."' WHERE usercode ='".$_SESSION['per_id']."' LIMIT 1");
}
mysqli_query($con,"UPDATE tbl_station SET Emp_Station='".$_POST['station']."',Emp_Position='".$_POST['position']."' WHERE Emp_ID='".$_SESSION['per_id']."'");
mysqli_query($con,"INSERT INTO tbl_deployment_history VALUES(NULL,'".$_POST['date_order']."','".$_POST['station']."','".$_POST['position']."','".$year."','".$_SESSION['per_id']."')");
echo '<script>
{
	alert("Successfully re-assign!!");
	window.location.href="personnel.php";
}
</script>';
?>
