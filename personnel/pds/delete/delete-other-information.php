<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');
mysqli_query($con,"DELETE FROM other_information WHERE other_information.Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."' AND other_information.No ='".$_GET['id']."' LIMIT 1");
header('location:' . GetHashURL('personnel', 'Personal Data Sheet'));
?>