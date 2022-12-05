<?php
session_start();
include("../vendor/jquery/function.php");
$str=sha1("Pagadian City Division Management information system");
if (isset($_POST['update_post']))
{

mysqli_query($con,"UPDATE tbl_memos SET Filename='".$_POST['message']."' WHERE FileCode='".$_SESSION['No']."' LIMIT 1");
	if (mysqli_affected_rows($con))
	{
		echo '<script>
				{
					alert("Successfully uploaded!");
					window.location.href="manage-memo.php?url=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9%27";
				}
			</script>';
	}
}
?>