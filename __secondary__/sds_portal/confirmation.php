<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
if ($_GET['id']=='Declined')
{
	mysqli_query($con,"UPDATE tbl_locator_passslip SET RequestStatus='Declined' WHERE  LocatorNo='".$_SESSION['Requestedby']."' LIMIT 1");
}elseif($_GET['id']=='Approved')
{
		mysqli_query($con,"UPDATE tbl_locator_passslip SET RequestStatus='Approved' WHERE  LocatorNo='".$_SESSION['Requestedby']."' LIMIT 1");
}
header('location:./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("locators")));				
?>