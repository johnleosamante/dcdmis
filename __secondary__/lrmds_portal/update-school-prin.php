<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
	<h4 class="modal-title" id="myModalLabel">Update School Data</h4>
	</div>
	<form action=""	Method="POST">
											
		
				<div class="modal-body">
				<label>List of Personnel</label>
				<select name="list" class="form-control">
				<option value="">--select--</option>
				<?php
				session_start();
				include("../vendor/jquery/function.php");
				$_SESSION['school_id']=$_GET['id'];
				$myassign=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_station.Emp_Category = 'PRINCIPAL' ORDER BY Emp_LName Asc");
				while($rowassign=mysqli_fetch_array($myassign))
					{
						echo '<option value="'.$rowassign['Emp_ID'].'">'.$rowassign['Emp_LName'].', '.$rowassign['Emp_FName'].'</option>';
					}
			?>												
			</select><hr/>
			<input type="submit" name="Assign" value="Assign" class="btn btn-primary">
											  
			</form>
		</div>