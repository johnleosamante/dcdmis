<?php
session_start();
include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
$result=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID <>'123131'");
$no=0;
while($row=mysqli_fetch_array($result))
{
$no++;
	if ($_POST['part-'.$no]<>"")
	{	
	 mysqli_query($con,"INSERT INTO tbl_school_participant VALUES(NULL,'".$_SESSION['code']."','".$_POST['part-'.$no]."')");
	 mysqli_query($con,"INSERT INTO tbl_messages VALUES (NULL,'SGOD','".$_POST['part-'.$no]."','".$_SESSION['code']."','".date('Y-m-d')."','Unread','Training')");
	}
}
echo '<script>
{
	alert("Successfully Added!!");
	window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_activity")).'";
}
</script>';
exit;
?>
