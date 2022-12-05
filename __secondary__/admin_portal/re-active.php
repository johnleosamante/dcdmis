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
					echo '<form action="" Method="POST" enctype="multipart/form-data">
						
						
						<br/>
						
						<label style="width:100%;"><input type="submit" name="update" value="ACTIVATE" class="btn btn-primary"></label></form>
					';
					
					?>
					
		</div>
		<!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
		