<?php
session_start();
include("../vendor/jquery/function.php");
mysqli_query($con,"DELETE FROM post WHERE id='".$_GET['id']."' LIMIT 1");
echo '<script>{alert("Successfully deleted!");window.location.href="list_of_announcement.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c";}</script>';
?>									