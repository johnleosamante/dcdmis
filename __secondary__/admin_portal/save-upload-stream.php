<?php
session_start();
include("../vendor/jquery/function.php");
$str=sha1("Pagadian City Division Management information system");
if (isset($_POST['upload-down']))
{

date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");

mysqli_query($con,"INSERT INTO tbl_streaming VALUES(NULL,'".$dateposted."','".$_POST['File_title']."','".$_POST['File_link']."','".$_SESSION['uid']."','New')");
if (mysqli_affected_rows($con))
{
echo '<script>
			{
				alert("Successfully uploaded!");
				window.location.href="manage-live.php?url=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9";
			}
		</script>';
}

}
?>