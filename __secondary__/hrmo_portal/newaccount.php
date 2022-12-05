  <div class="modal-header">
         
          <h3 class="modal-title"><center>SET NEW ACCOUNT</center></h3>
		
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<?php
		session_start();
include("../../pcdmis/vendor/jquery/function.php");

foreach ($_GET as $key => $data)
{
$id=$_GET[$key]=base64_decode(urldecode($data));
	
}
					$_SESSION['per_id']=$id;
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$id."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					$_SESSION['SchoolID']= $data['Emp_Station'];
					echo '<b>';
					echo '<img src="../../../pcdmis/images/'.$data['Picture'].'" width="150" height="160" align="right">';
					echo '<p>Employee ID: '.$_GET['id'].'</p>';
					echo '<p>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</p>';
					echo '<p>Current Station: '.$data['SchoolName'].'</p>';
					echo  '<p>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</p>';
					echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p><hr/>';
					$maccount=mysqli_query($con,"SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='".$data['Emp_Email']."' LIMIT 1");
					$ndata=mysqli_fetch_assoc($maccount);				
					echo '
					<label> Username: </label><label><input name="uname" type="email" class="form-control" value="'.$data['Emp_Email'].'"></label><br/>';
					echo '<label> Password: </i></label><label><input name="upass" type="password" class="form-control" value="'.$ndata['Teacher_Password'].'"></label>
					
						</div>	 
						<div class="modal-footer">
						<label style="width:30%;float:left;">
						<p>Designation: </p>
						<select name="position" class="form-control" required>
								<option value="">--Select--</option>
								<option value="STAFF">STAFF</option>
								<option value="RECORD">RECORD</option>
								<option value="CLERK">CLERK</option>
								
							</select>
							</label>
						<label><input type="submit" name="Create" value="Create" class="btn btn-success" style="padding:4px;margin:4px;"></label>
					 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
					';
					
					?>
					
		</div>
		</form>