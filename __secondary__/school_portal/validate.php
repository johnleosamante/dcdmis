<?php
session_start();
$str=sha1("pagadian City division management information system");
if ($_GET['district']<>"")
{
$_SESSION['dist']=$_GET['district'];
header("location:view_details.php?link=".$str);
}elseif ($_GET['sr']<>"")
{
	$_SESSION['per_sr']=$_GET['sr'];
	header("location:service_record.php?link=".$str);
}
elseif ($_GET['id']<>"")
{
	$_SESSION['EmpID']=$_GET['id'];
	header("location:pds.php?link=".$str);
}
?>