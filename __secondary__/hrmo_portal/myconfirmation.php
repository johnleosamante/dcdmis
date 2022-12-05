  <?php
  session_start();
include("../../pcdmis/vendor/jquery/function.php");
  $_SESSION['TCode']=$_GET['id'];
  $result=mysqli_query($con,"SELECT * FROM tbl_online_application INNER JOIN tbl_employee ON tbl_online_application.Emp_ID =tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_online_application.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position =tbl_job.Job_code WHERE tbl_online_application.Transaction_number='".$_SESSION['TCode']."'");
  $row=mysqli_fetch_assoc($result);						
  
echo '<div class="modal-header">
         
          <h3 class="modal-title"><center>Information for Confirmation</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<label>Employee ID:</label>
		<input type="text" value="'.$row['Emp_ID'].'" class="form-control" disabled>
		<label>Employee Name:</label>
		<input type="text" class="form-control" value="'.$row['Emp_LName'].', '.$row['Emp_FName'].' '.$row['Emp_MName'].'" disabled>
		<label>Current Position:</label>
		<input type="text" class="form-control" value="'.$row['Job_description'].'" disabled>
		<label>Application for:</label>
		<input type="text" class="form-control" value="'.$row['Promotted_to'].'" disabled>
		
		</div>
		<div class="modal-footer">
		<input type="submit" name="submit" class="btn btn-success" value="Confirm" >
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload()">Close</button>
		
		</div></form>';
	 ?>		 