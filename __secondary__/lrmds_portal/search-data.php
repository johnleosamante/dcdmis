<?php
session_start();
$_SESSION['week']=$_POST['week'];
$_SESSION['quarter']=$_POST['quarter'];
header("location:readiness.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c");
?>