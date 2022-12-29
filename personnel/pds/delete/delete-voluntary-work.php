<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');
mysqli_query($con,"DELETE FROM voluntary_work WHERE voluntary_work.Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."' AND voluntary_work.No ='".$_GET['id']."' LIMIT 1");
header('location:' . GetHashURL('personnel', 'Personal Data Sheet'));
?>