<?php
session_start();
include("../vendor/jquery/function.php");
echo '<option value="">--select--</option>';

$result=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand WHERE SubStrandtype='".$_GET['id']."' AND SubGradeLevel ='".$_SESSION['SubGrade']."' ORDER BY SubStrandDescription Asc");

while($row=mysqli_fetch_array($result))
{	
echo '<option value="'.$row['StrandsubCode'].'">'.$row['SubStrandDescription'].'</option>';
}

?>