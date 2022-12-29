<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');
mysqli_query($con,"DELETE FROM learning_and_development WHERE learning_and_development.Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."' AND learning_and_development.No ='".$_GET['id']."' LIMIT 1");
header('location:' . GetHashURL('personnel', 'Personal Data Sheet'));
?>