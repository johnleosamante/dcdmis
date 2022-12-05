  <?php
  session_start();
include("../pcdmis/vendor/jquery/function.php");
  mysqli_query($con,"UPDATE tbl_messages SET Message_status='Read' WHERE No='".$_GET['id']."'");
$result=mysqli_query($con,"SELECT * FROM tbl_station INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_station.Emp_ID='".$_SESSION['EmpID']."'");
$row=mysqli_fetch_assoc($result); 
 echo '<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
		   <h3 class="modal-title"><center>Online Application</center></h3>
        </div>
        <div class="modal-body">
		<form action="save_application.php" Method="POST">
		<label>Date of Transaction</label>
		<input type="text" class="form-control"  value="'.date('m/d/Y').'"  disabled>
		<input type="hidden" class="form-control" name="Trandate" value="'.date('m-d-Y').'" >
		<label>Transaction Number</label>
		<input type="text" class="form-control"  value="'.$_SESSION['EmpID'].date('mdY').'"  disabled>
		<input type="hidden" class="form-control" name="TrackNo" value="'.$_SESSION['EmpID'].date('mdY').'" >
		<label>Employee Name</label>
		<input type="text" class="form-control"  value="'.$_SESSION['Per_Name'].'"  disabled>
		<label>Current Station</label>
		<input type="text" class="form-control"  value="'.$row['SchoolName'].'"  disabled>
		<label>Current Position</label>
		<input type="text" class="form-control"  value="'.$row['Job_description'].'"  disabled>
		<label>Promotted to</label>';
		
		if ($row['Emp_Position']=='T-1')
		{
		 echo '<input type="text" class="form-control"  value="Teacher II"  disabled>';
		 echo '<input type="text" name="newpost" class="form-control"  value="Teacher II">';
		}else{
		 echo '<input type="text" class="form-control"  value="Teacher III"  disabled>';
		 echo '<input type="hidden" name="newpost" class="form-control"  value="Teacher III" >';
		}
		echo '<hr/>
		<input type="submit" class="btn btn-success" name="submit" value="APPLY NOW">
		</form>
		</div>';
		  ?>
		
	
	