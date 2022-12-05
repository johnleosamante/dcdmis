  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>PERSONNEL INFOMATION</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
		include("../vendor/jquery/function.php");
					$_SESSION['per_id']=$_GET['id'];
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['id']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					$_SESSION['SchoolID']= $data['Emp_Station'];
					$_SESSION['EmpID']=$_GET['id'];
					echo '<b>';
					echo '<img src="'.$data['Picture'].'" width="150" height="160" align="right">';
					echo '<p>Employee ID: '.$_GET['id'].'</p>';
					echo '<p>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</p>';
					echo '<p>Current Station: '.$data['SchoolName'].'</p>';
					echo  '<p>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</p>';
					echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p><hr/>';
					echo '<form action="archive.php?link='.sha1("Deped Pagadian Online Management System version 1.0").'" Method="POST">
						<label style="width:50%;float:left;">
							<label>Date of Appointment</label>
						<label  style="width:100%;padding:4px;">
							<input type="date" name="date_return" class="form-control" required>
						</label>
						</label>
						<label style="width:50%;float:left;">
						<label>Station</label>
						<label style="width:100%;padding:4px;">
						<select name="remark" class="form-control" required>
							<option value="">--Select--</option>';
							$station=mysqli_query($con,"SELECT * FROM tbl_school ORDER BY SchoolName Asc");
							while ($rowstation=mysqli_fetch_array($station))
							{
								echo '<option value="'.$rowstation['SchoolID'].'">'.$rowstation['SchoolName'].'</option>';
							}
							
						echo '</select>
						</label>
						</label>
						<label style="width:50%;float:left;">
						<label>Position</label>
						<label style="width:100%;padding:4px;">
						<select name="remark" class="form-control" required>
							<option value="">--Select--</option>';
							$myposition=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
							while($rowjob=mysqli_fetch_array($myposition))
							{
								echo '<option value="'.$rowjob['Job_code'].'">'.$rowjob['Job_description'].'</option>';
							}
							
							
						echo '</select>
						</label>
						</label>
						<br/>
						
						<label style="width:100%;"><input type="submit" name="update" value="SUBMIT" class="btn btn-primary"></label></form>
					';
					
					?>
					
		</div>
		<!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
		