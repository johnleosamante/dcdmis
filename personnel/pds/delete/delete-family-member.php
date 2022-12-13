<?php
include_once('../../../_includes_/function.php');
include_once('../../../_includes_/database/database.php');
mysqli_query($con,"DELETE FROM family_background WHERE Emp_ID='".$_SESSION['EmpID']."' AND No ='".$_GET['id']."' LIMIT 1");
header('location:' . GetHashURL('personnel', 'Personal Data Sheet'));
?>