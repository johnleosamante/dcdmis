  <?php
  session_start();
  include("../../pcdmis/vendor/jquery/function.php");
  foreach ($_GET as $key => $data)
	{
	$url=$_GET[$key]=base64_decode(urldecode($data));
		
	}
	$_SESSION['AccountNo']=$url;
  $result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Appl_No='".$url."' LIMIT 1");
  $row=mysqli_fetch_assoc($result);
  echo '<div class="modal-header">
         
          <h3 class="modal-title"><center>Update Applicant Information</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>FAMILY NAME: </label>
		<input type="text" class="form-control" name="FName" placeholder="Family Name" value="'.$row['Last_Name'].'" required>
		<label>GIVEN NAME: </label>
		<input type="text" class="form-control" name="GName" placeholder="Given Name" value="'.$row['First_Name'].'" required>
		<label>MIDDLE NAME: </label>
		<input type="text" class="form-control" name="MName" placeholder="Middle Name" value="'.$row['Middle_Name'].'" required>
		<label>SEX: </label>
		<select class="form-control" name="sex" required>';
		if ($row['Gender']=='MALE')
		{
		  echo '<option value="MALE">MALE</option>
		  <option value="FEMALE">FEMALE</option>';
		}else{
			 echo '<option value="FEMALE">FEMALE</option>
		  <option value="MALE">MALE</option>';
		} 
		echo '</select>
		<label>CONTACT #</label>
		<input type="number" class="form-control" name="CellNo" placeholder="Contact Number" value="'.$row['Contact_No'].'"required>
		<label>HOME ADDRESS</label>
		<textarea class="form-control" name="homeaddress" rows="2" required>'.$row['Home_Address'].'</textarea>
		<label>MAJOR</label>
		<input type="text" class="form-control" name="Major" placeholder="Major Subject" required value="'.$row['Major'].'">
		</div>
		 <div class="modal-footer">
		<input type="submit" name="update_applicant" Value="UPDATE" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
		</form>';
	?>	