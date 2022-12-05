<?php
session_start();
$str=sha1("Pagadian City Division Management information system");
if ($_GET['district']<>"")
{
$_SESSION['dist']=$_GET['district'];
header("location:view_details.php?link=".$str);
}elseif ($_GET['sr']<>"")
{
	$_SESSION['per_sr']=$_GET['sr'];
	header("location:service_record.php?link=".$str);
}elseif ($_GET['school_ID']<>"")
{
	$_SESSION['school_id']=$_GET['school_ID'];
	header("location:view_profile.php?link=".$str);
}
elseif ($_GET['EmpID']<>"")
{
	$_SESSION['EmpID']=$_GET['EmpID'];
	header("location:pds.php?link=".$str);
}
?>