<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
 mysqli_query($con,"DELETE FROM tbl_vehicle_reservation  WHERE No ='".$_SESSION['updatevehicle']."' AND RequestStatus='For Approval' LIMIT 1");							
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("vehicle")));
?>