<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
?>
 <div class="modal-header">
          
          <h3 class="modal-title"><center>ADD IPCRF</center></h3>
		 
        </div>
		 <form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		Personnel Name:
					<select name="PName" class="form-control" required>
				     
						<?php
						   $myname=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$_GET['code']."' ORDER BY Emp_LName Asc");
						   while($rowName=mysqli_fetch_array($myname))
						   {
							   echo ' <option value="'.$rowName['Emp_ID'].'">'.$rowName['Emp_LName'].', '.$rowName['Emp_FName'].'</option>';
						   }
						 ?>
					 </select>	
			Position:
					<select name="position" class="form-control" required>
				      <option value="">--Select--</option>
						<?php
						   $myjob=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
						   while($rowjob=mysqli_fetch_array($myjob))
						   {
							   echo ' <option value="'.$rowjob['Job_code'].'">'.$rowjob['Job_description'].'</option>';
						   }
						 ?>
					 </select>								
			Rating: <input type="text" name="rating" class="form-control" required>
			Remarks <select name="remarks" class="form-control" required>
						<option value="">--Select--</option>
						<option value="OUTSTANDING">OUTSTANDING</option>
						<option value="VERY SATISFACTORY">VERY SATISFACTORY</option>
						<option value="SATISFACTORY">SATISFACTORY</option>
						<option value="UNSATISFACTORY">UNSATISFACTORY</option>
						<option value="POOR">POOR</option>
					</select>
			School Year:<select name="sy" class="form-control" required>
				   <!--<option value="">--Select--</option>-->
					  <?php
						   $myyear=mysqli_query($con,"SELECT * FROM tbl_school_year WHERE SYCode='2021' ORDER BY SYCode Desc");
							   while($rowyear=mysqli_fetch_array($myyear))
							   {
								   echo ' <option value="'.$rowyear['SYCode'].'">'.$rowyear['SchoolYear'].'</option>';
							   }
						?>
						</select>
			School:<select name="school" class="form-control" required>
				 <!--<option value="">--Select--</option>-->
				  <?php
				   $myschool=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID='126050' ORDER BY SchoolName Asc");
				   while($rowschool=mysqli_fetch_array($myschool))
					   {
						   echo ' <option value="'.$rowschool['SchoolID'].'">'.$rowschool['SchoolName'].'</option>';
					   }
				   ?>
				</select>
		</div>	
		 <div class="modal-footer">
		  <input type="submit" name="AddScore" value="SUBMIT" class="btn btn-primary">
		  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		 </form>