<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');
mysqli_query($con,"DELETE FROM civil_service WHERE civil_service.Emp_ID='".$_SESSION['EmpID']."' AND civil_service.No ='".$_GET['id']."' LIMIT 1");
header('location:' . GetHashURL('personnel', 'Personal Data Sheet'));
?>