<?php
session_start();
include("../vendor/jquery/function.php");
$_SESSION['Strand']=$_GET['id'];
echo '<option value="">--select--</option>';

$result=mysqli_query($con,"SELECT * FROM tbl_senior_strand_type");

while($row=mysqli_fetch_array($result))
{	
echo '<option value="'.$row['StrandCode'].'">'.$row['StrandDescription'].'</option>';
}

?>