  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Principal Assigned</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="save_assignment.php" Method="POST">
		<?php
			session_start();
			include("../vendor/jquery/function.php");
			$result=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID =tbl_employee.Emp_ID WHERE tbl_school.SchoolID='".$_GET['id']."' LIMIT 1");
			$row=mysqli_fetch_assoc($result);
			$_SESSION['myID']=$_GET['id'];
		echo '<label>School ID: '.$_GET['id'].'</label><br/>
			 <label>School Name: '.$row['SchoolName'].'</label><br/>
			 <label>Address: '.$row['Address'].'</label><br/>
			 <label>Previous Incharge: '.$row['Emp_LName'].', '.$row['Emp_FName'].'</label><hr/>';
			 echo '<label>Select New Assign Incharge</label><br/>
				<label style="width:85%;padding:10px;"><select name="newprin" class="form-control">
				<option value="">--Select--</option>';
				$data=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_station.Emp_Category ='PRINCIPAL' ORDER BY tbl_employee.Emp_LName Asc");
				while($drow=mysqli_fetch_array($data))
				{
				 echo '<option value="'.$drow['Emp_ID'].'">'.$drow['Emp_LName'].','.$drow['Emp_FName'].'</option>';	
				}
			 echo '</select></label><label>
			 <input type="submit" name="update" value="Update" class="btn btn-success"></label>';
		?>
		</form>
		</div>