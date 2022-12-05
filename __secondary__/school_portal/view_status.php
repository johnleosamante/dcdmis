 <?php
	session_start();
	include("../vendor/jquery/function.php");
	
		if ($_GET['id']=='Transfer')
		{			
		echo '<label>Station / School </label>	
		<select name="station"  class="autoselect2 form-control form-control" required>
		<option name="">--Select--</option>';
		
		
		$rec=mysqli_query($con,"SELECT * FROM tbl_school") or die ("School Table not found!");
		while($row=mysqli_fetch_array($rec))
		{
		echo '<option value="'.$row['SchoolID'].'">'.$row['SchoolName'].'</option>';
		}
		
		echo '</select>
		<label>Position: </label>	
		<select name="position" class="form-control">
		<option value="-">--Select--</option>';
			
			$mypost=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
			while($post=mysqli_fetch_array($mypost))
				{
				echo '<option value="'.$post['Job_code'].'">'.$post['Job_description'].'</option>';
				}
			
		echo '</select>';
		}
		?>
		