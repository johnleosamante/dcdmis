  <div class="modal-header">
          
          <h3 class="modal-title"><center>SET ACCOUNT</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
		include_once("../../pcdmis/vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
				{
				$id=$_GET[$key]=base64_decode(urldecode($data));
					
				}
					$_SESSION['per_id']=$id;
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$id."'"); 
					 $data=mysqli_fetch_assoc($emp_info);
					$_SESSION['SchoolID']= $data['Emp_Station'];
					echo '<b>';
					echo '<img src="../../../pcdmis/images/'.$data['Picture'].'" width="150" height="160" align="right">';
					echo '<p>Employee ID: '.$id.'</p>';
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
						<label style="width:35%;"><input name="upass"  id="password" type="password" class="form-control" value="'.$data['Emp_Month'].$data['Emp_Day'].$data['Emp_Year'].'"></label><br/>
						<label><input type="submit" name="reset" value="Reset" class="btn btn-success" style="padding:4px;margin:4px;"></label></form>';
					}else{					
					echo '<form action="create.php" Method="POST">
						<label> Email add / Username </label><br/>
						<label style="width:35%;"><input name="uname" type="email" class="form-control" value="'.$data['Emp_Email'].'"></label><br/>';
					echo '<label style="width:35%;"><input id="password" name="upass" type="password" value="'.$data['Emp_Month'].$data['Emp_Day'].$data['Emp_Year'].'" class="form-control"  title="Password must contain at least 6 characters, including UPPER/lowercase and numbers"></label><br/>
					<br/>
						
						<input type="submit" name="Create" value="Create" class="btn btn-success" style="padding:4px;margin:4px;">					
					</form>';
					}
					?>
					
					
		</div>
		  <div class="modal-footer">
		   <input   type="checkbox" onclick="PassUser()" />
            <label  >Show Password</label>
			
			<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>	
		  </div>
		  
		<!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
		
<script>
  function PassUser(){
    var x = document.getElementById('password');
    if (x.type === 'password') {
    x.type = 'text';
    } else {
    x.type = 'password';
    }}
</script> 	