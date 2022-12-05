<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$result=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$_SESSION['Current_LRN']."' AND tbl_activity_learner_score.SubCode='".$_SESSION['SubCode']."' AND tbl_performance_task.Quarter='".$_SESSION['Current_Quarter']."' AND tbl_performance_task.activity_remark='RECORDED' AND tbl_performance_task.QCode='".$_GET['id']."' ORDER BY QCode Asc LIMIT 1");
$row=mysqli_fetch_assoc($result);				

//Number of Item
$myptitem=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter='".$_SESSION['Current_Quarter']."' AND activity_remark='RECORDED' AND Grade='".$_SESSION['Grade']."' AND SecCode ='".$_SESSION['SecCode']."' AND SYCode ='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND tbl_performance_task.QCode='".$_GET['id']."' ORDER BY Date_created Asc LIMIT 1");
$rowitem=mysqli_fetch_assoc($myptitem);															
echo '<label>No. of Item:</label>
<input type="text"  class="form-control" value="'.$rowitem['ItemNo'].'" disabled>
<input type="hidden" name="itemNo" class="form-control" value="'.$rowitem['ItemNo'].'"><br/>';
echo '<label>Enter Score:</label>
<input type="text" name="newscore" class="form-control" value="'.$row['Score'].'"><br/>';
?>
