  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>PERSONNEL ACCOUNT</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
		include("../pcdmis/vendor/jquery/function.php");
					$_SESSION['per_id']=$_GET['id'];
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['id']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					$_SESSION['SchoolID']= $data['Emp_Station'];
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
					echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p>';
					$maccount=mysqli_query($con,"SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='".$data['Emp_Email']."' LIMIT 1");
					$mrow=mysqli_fetch_assoc($maccount);
					echo  '<p>Last Signin: '.$mrow['Last_login'].'</p><hr/>';
					if (mysqli_num_rows($maccount)<>0)
					{
						
						echo '<form action="reset.php?email='.$mrow['Teacher_TIN'].'" Method="POST">
						<label> Username: </label><br/>
						<label style="width:35%;"><input name="uname" type="email" class="form-control" value="'.$mrow['Teacher_TIN'].'"></label><br/>';
						echo '
						<input name="upass" type="hidden" class="form-control" value="'.$data['Emp_Month'].$data['Emp_Day'].$data['Emp_Year'].'"><br>
						<label style="width:35%;">	
						<select name="position" class="form-control" required>
						<option value="">--Select--</option>';
						
						$myoffice=mysqli_query($con,"SELECT * FROM tbl_deparment");
						while ($rowoffice=mysqli_fetch_array($myoffice))
							
						{
							echo '<option value="'.$rowoffice['Offices'].'">'.$rowoffice['Offices'].'</option>';
						}
						
						echo '<option value="MIS">MIS</option>';
						echo '<option value="ICT COORDINATOR">ICT COORDINATOR</option>
						<option value="PROPERTY CUSTODIAN">PROPERTY CUSTODIAN</option>
						<option value="TEACHER">TEACHER</option>
						</select></label><br/>
						<label><input type="submit" name="reset" value="Reset Account" class="btn btn-success" style="padding:4px;margin:4px;"></label></form>';
					}else{					
					echo '<form action="create.php" Method="POST">
						<label> Email add / Username </label><br/>
						<label style="width:35%;"><input name="uname" type="email" class="form-control" value="'.$data['Emp_Email'].'"></label><br/>';
					echo '<label style="width:35%;"><input name="upass" type="hidden" value="'.$data['Emp_Month'].$data['Emp_Day'].$data['Emp_Year'].'" class="form-control"  title="Password must contain at least 6 characters, including UPPER/lowercase and numbers"></label>
					<br/><label style="width:35%;">	
						<select name="position" class="form-control" required>
						<option value="">--Select--</option>';
						
						$myoffice=mysqli_query($con,"SELECT * FROM tbl_deparment ORDER BY Offices Asc");
						while ($rowoffice=mysqli_fetch_array($myoffice))
							
						{
							echo '<option value="'.$rowoffice['Offices'].'">'.$rowoffice['Offices'].'</option>';
						}
						echo '<option value="MIS">MIS</option>';
						echo '<option value="ICT COORDINATOR">ICT COORDINATOR</option>
						<option value="PROPERTY CUSTODIAN">PROPERTY CUSTODIAN</option>
						<option value="TEACHER">TEACHER</option>
						</select></label><br/>
						
						<input type="submit" name="Create" value="Create Account" class="btn btn-success" style="padding:4px;margin:4px;">			
					</form>';
					}
					?>
					
		</div>
		<!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
		