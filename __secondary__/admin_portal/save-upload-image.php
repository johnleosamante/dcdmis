<?php
session_start();
include("../vendor/jquery/function.php");
$str=sha1("Pagadian City Division Management information system");
if (isset($_POST['upload-down']))
{
ini_set('mysql.connect_timeout',300);
ini_set('default_socket_timeout',300);
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");
$uploaddir = '../../images/slider/';

$uploadfile = $uploaddir . basename($_FILES['images']['name']);

//$filesize = round(($_FILES['upload']['size']/1024), 2);
//$ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
move_uploaded_file($_FILES['images']['tmp_name'], $uploadfile);
mysqli_query($con,"INSERT INTO slider_img VALUES(NULL,'".$_POST['File_title']."','".$_POST['File_sub']."','".$uploadfile."','".$dateposted."','".$_SESSION['uid']."','Show','-','#')");
if (mysqli_affected_rows($con)==1)
{
echo '<script>
			{
				alert("Successfully uploaded!");
				window.location.href="manage-slider.php?url=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9";
			}
		</script>';
}

}
?>