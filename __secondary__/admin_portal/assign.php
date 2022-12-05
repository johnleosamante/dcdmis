  <div class="modal-header">
         
          <h3 class="modal-title"><center>New Principal Assign</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<?php
			session_start();
		   include("../pcdmis/vendor/jquery/function.php");
			foreach ($_GET as $key => $data)
					{
					$id=$_GET[$key]=base64_decode(urldecode($data));
						
					}
			$result=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID =tbl_employee.Emp_ID WHERE tbl_school.SchoolID='".$id."' LIMIT 1");
			$row=mysqli_fetch_assoc($result);
			$_SESSION['myID']=$id;
			
		echo '<label>School ID: '.$id.'</label><br/>
			 <label>School Name: '.$row['SchoolName'].'</label><br/>
			 <label>Address: '.$row['Address'].'</label><br/>
			 <label>Previous Incharge: '.$row['Emp_LName'].', '.$row['Emp_FName'].'</label><br/>';
			 echo '<label>Select New Assign Incharge</label><br/>
				
				<select name="newprin" class="form-control">
				<option value="">--Select--</option>';
				$data=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID  ORDER BY tbl_employee.Emp_LName Asc");
				while($drow=mysqli_fetch_array($data))
				{
				 echo '<option value="'.$drow['Emp_ID'].'">'.$drow['Emp_LName'].','.$drow['Emp_FName'].'</option>';	
				}
			echo '</select>';
		?>
		
		</div>
		 <div class="modal-footer">
		  <input type="submit" name="update" value="Update" class="btn btn-success">
		   <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>