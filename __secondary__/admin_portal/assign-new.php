  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New School Assigned</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="view_profile.php?link=13b714fad9eca2a00fe69ce8ce03cba1c7e08527" Method="POST">
		<?php
			session_start();
			include("../vendor/jquery/function.php");
		
			$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID  WHERE tbl_employee.Emp_ID ='".$_GET['id']."' LIMIT 1");
				
			$row=mysqli_fetch_assoc($result);
			$_SESSION['myID']=$_GET['id'];
		echo '<label>Emp ID: '.$_GET['id'].'</label><br/>
			 <label>Name: '.$row['Emp_LName'].', '.$row['Emp_FName'].'</label><br/>
			 <label>Address: '.$row['Emp_Address'].'</label><br/>
			 <label>Previous Incharge: '.$row['Emp_LName'].', '.$row['Emp_FName'].'</label><hr/>';
			 echo '<label>Select New Assign Incharge</label><br/>
				<label style="width:85%;padding:10px;"><select name="newprin" class="form-control">
				<option value="">--Select--</option>';
				$data=mysqli_query($con,"SELECT * FROM tbl_school ORDER BY SchoolName Asc");
				while($drow=mysqli_fetch_array($data))
				{
				 echo '<option value="'.$drow['SchoolID'].'">'.$drow['SchoolName'].'</option>';	
				}
			 echo '</select></label><label>
			 <input type="submit" name="update" value="SUBMIT" class="btn btn-success"></label>';
		?>
		</form>
		</div>