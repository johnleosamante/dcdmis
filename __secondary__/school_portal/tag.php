<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$query=mysqli_query($con,"SELECT * FROM tbl_assessment WHERE Type_of_assessment='".$_GET['id']."' AND SchoolID='".$_SESSION['school_id']."' AND School_Year='".$_SESSION['year']."' AND LRN='".$_SESSION['lrn']."'");
if(mysqli_num_rows($query)==1)
{
	echo '<label class="btn btn-success">Learner is already tag for this examination.</label>
	<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>';
}else{
	echo '<input type="submit" name="tagasexaminee" value="TAG AS EXAMINEE" class="btn btn-primary">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
}
?>