  <div class="modal-header">
         
          <h3 class="modal-title"><center>PERSONNEL INFOMATION</center></h3>
		
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<?php
		session_start();
				include("../pcdmis/vendor/jquery/function.php");
					$_SESSION['per_id']=$_GET['id'];
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['id']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					$_SESSION['SchoolID']= $data['Emp_Station'];
					$_SESSION['EmpID']=$_GET['id'];
					 if ($data['Picture']<>NULL)
						 {
							echo  '<img src="../../../pcdmis/images/'.$data['Picture'].'" style="width:200px;height:200px;" align="right">';
						 }else{
							 echo  '<img src="../../pcdmis/logo/user.png" style="width:200px;height:200px;" align="right">';
						 
						 }
					echo '<p>Employee ID: '.$_GET['id'].'</p>';
					echo '<p>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</p>';
					echo '<p>Current Station: '.$data['SchoolName'].'</p>';
					echo  '<p>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</p>';
					echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p><hr/>';
					echo '
						<label style="width:50%;float:left;">
							<label>Date Last Attended</label>
						<label  style="width:100%;padding:4px;">
							<input type="date" name="date_retired" class="form-control" required>
						</label>
						</label>
						<label style="width:50%;float:left;">
						<label>Remarks</label>
						<label style="width:100%;padding:4px;">
						<select name="remark" class="form-control" required>
							<option value="">--Select--</option>
							<option value="Retired">Retired</option>
							<option value="Resigned">Resigned</option>
							<option value="Removed">Duplicate</option>
							<option value="De-Activate">De-Activate</option>
							
						</select>
						</label>
						</label>
					';
					
					?>
					
		</div>
		 <div class="modal-footer">
		 <input type="submit" name="update" value="SUBMIT" class="btn btn-primary">
		  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>
		<!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
		