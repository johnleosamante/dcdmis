  <div class="modal-header">
          
          <h3 class="modal-title"><center>New Assignment Order</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
  
		<label>Date Assignment</label>
		<input type="date" name="date_order" class="form-control" required>
		<label>Station / School </label>	
		<select name="station"  class="autoselect2 form-control form-control" required>
		<option name="">--Select--</option>
		<?php
		session_start();
	include("../../pcdmis/vendor/jquery/function.php");
		
		$rec=mysqli_query($con,"SELECT * FROM tbl_school") or die ("School Table not found!");
		while($row=mysqli_fetch_array($rec))
		{
		echo '<option value="'.$row['SchoolID'].'">'.$row['SchoolName'].'</option>';
		}
		?>
		</select>
		<label>Position: </label>	
		<select name="position" class="form-control">
		<option value="-">--Select--</option>
			<?php
			$mypost=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
			while($post=mysqli_fetch_array($mypost))
				{
				echo '<option value="'.$post['Job_code'].'">'.$post['Job_description'].'</option>';
				}
			?>
		</select>
		<label>Step: </label>	
			<input type="text" name="step" class="form-control" required>
		</div>
		  <div class="modal-footer">
		
		<input type="submit" name="new_assign" value="Save" class="btn btn-primary">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div></form>