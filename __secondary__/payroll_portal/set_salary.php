 
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
		$result=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_ID='".$url."' ORDER BY Emp_LName Asc");
		$row=mysqli_fetch_array($result);
		echo '
			<label >Personnel Name:</label>
			<label style="width:100%;">
			<input type="text" class="form-control" value="'.$row['Emp_LName'].', '.$row['Emp_FName'].' '.$row['Emp_MName'].'" disabled>
			<input type="hidden" name="PName" class="form-control" value="'.$row['Emp_ID'].'">
			';
			
	  echo '</select></label>
			<label >Basic Salary:</label>
			<label style="width:100%;"><input type="text" name="Basic" class="form-control"></label>
			<label >PERA/ACA:</label>
			<label style="width:100%;"><input type="text" name="PERA" class="form-control"></label><hr/>
			';
		?>
		</div>
		<div class="modal-footer">
		 <input type="submit" name="add" class="btn btn-primary" value="SUBMIT">
			
		</div>
		</form>