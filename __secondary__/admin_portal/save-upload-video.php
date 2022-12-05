<?php
session_start();
include("../vendor/jquery/function.php");
$str=sha1("Pagadian City Division Management information system");
if (isset($_POST['upload-down']))
{
ini_set('mysql.connect_timeout',300);
ini_set('default_socket_timeout',300);
$datepost=date("Y-m-d");
$uploaddir = '../../files/videos/'.$_POST['filename'];

mysqli_query($con,"INSERT INTO tbl_video VALUES('".date('ydms')."','".$datepost."','".$_POST['File_name']."','".$uploaddir."','".$_SESSION['uid']."')");
if (mysqli_affected_rows($con))
{
	echo '<script>
			{
				alert("Successfully uploaded!");
				window.location.href="manage-video.php?url=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9";
			}
		</script>';
}

}
?>