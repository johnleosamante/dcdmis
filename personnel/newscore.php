<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$_SESSION['Current_LRN']."' AND tbl_activity_learner_score.SubCode='".$_SESSION['SubCode']."' AND tbl_written_work_set_activity.Quarter='".$_SESSION['Current_Quarter']."' AND tbl_written_work_set_activity.activity_remark='RECORDED' AND tbl_written_work_set_activity.QCode='".$_GET['id']."' ORDER BY QCode Asc LIMIT 1");
$row=mysqli_fetch_assoc($result);				

//Number of Item
$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = '".$_SESSION['Current_Quarter']."' AND activity_remark='RECORDED' AND QCode='".$_GET['id']."' LIMIT 1");
$rowitem=mysqli_fetch_assoc($mywwitem);															
echo '<label>No. of Item:</label>
<input type="text"  class="form-control" value="'.$rowitem['ItemNo'].'" disabled>
<input type="hidden" name="itemNo" class="form-control" value="'.$rowitem['ItemNo'].'"><br/>';
echo '<label>Enter Score:</label>
<input type="text" name="newscore" class="form-control" value="'.$row['Score'].'"><br/>';
?>
