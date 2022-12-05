 
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>UPDATE PERSONNEL SALARY</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<?php
		session_start();
		include("../../pcdmis/vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
			{
			$url=$_GET[$key]=base64_decode(urldecode($data));
				
			}
			$_SESSION['newid']=$url;
		$result=mysqli_query($con,"SELECT * FROM tbl_f7_salary INNER JOIN tbl_employee ON tbl_f7_salary.Emp_ID=tbl_employee.Emp_ID WHERE tbl_f7_salary.Emp_ID = '".$url."' ORDER BY Emp_LName Asc");
		$row=mysqli_fetch_assoc($result);
		echo '
			<label >Personnel Name:</label>
			<label style="width:100%;">
			<select name="PName" class="form-control">';
			
			
			
				echo '<option value="'.$row['Emp_ID'].'">'.$row['Emp_LName'].', '.$row['Emp_FName'].' '.$row['Emp_MName'].'</option>';
			
	  echo '</select></label>
			<label >Basic Salary:</label>
			<label style="width:100%;"><input type="text" name="Basic" value="'.$row['Basic_Salary'].'" class="form-control"></label>
			<label >PERA/ACA:</label>
			<label style="width:100%;"><input type="text" name="PERA" value="'.$row['PERA_ACA'].'" class="form-control"></label><hr/>
			';
		?>
		</div>
		
		<div class="modal-footer">
		 <input type="submit" name="update" class="btn btn-primary" value="UPDATE">
			
		</div>
</form>