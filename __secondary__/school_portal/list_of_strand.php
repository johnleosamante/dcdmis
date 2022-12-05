<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
echo '<option value="">--select--</option>';
$result=mysqli_query($con,"SELECT * FROM tbl_qualification WHERE Track='".$_GET['id']."' AND Grade ='".$_SESSION['SubGrade']."' ORDER BY Description Asc");
while($row=mysqli_fetch_array($result))
{	
echo '<option value="'.$row['SpCode'].'">'.$row['Description'].'</option>';
}

?>