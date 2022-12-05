  <?php
  session_start();
include("../pcdmis/vendor/jquery/function.php");
  mysqli_query($con,"UPDATE tbl_messages SET Message_status='Read' WHERE No='".$_GET['code']."'");
  
  echo '<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
		  <a href="my_participant.php?TCode='.$_GET['TCode'].'" class="btn btn-primary" style="float:right;" data-target="#parti" data-toggle="modal">View</a>
          <h3 class="modal-title"><center>Message Information</center></h3>
        </div>
        <div class="modal-body">
		<label>TITLE OF TRAINING: </label><br/>';
		$result=mysqli_query($con,"SELECT * FROM tbl_school_participant INNER JOIN tbl_seminar ON tbl_school_participant.Training_Code =tbl_seminar.Training_Code WHERE tbl_school_participant.SchoolID='".$_SESSION['school_id']."' AND tbl_school_participant.Training_Code='".$_GET['TCode']."'");
		$row=mysqli_fetch_assoc($result);	
		echo '<input type="text" class="form-control" value="'.$row['Title_of_training'].'" disabled>
		<label>MEMO </label><br/>';
		if ($row['Training_Memo']<>"-")
		{
		echo '<iframe src="../'.$row['Training_Memo'].'" width="100%" height="450"></iframe>'; 		
		}else{
		echo '<iframe src="nomemo.php" width="100%" height="450"></iframe>'; 		
		}
		echo '</div>';
	?>	
	
	