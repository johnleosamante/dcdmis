 <?php
 session_start();
include("../../pcdmis/vendor/jquery/function.php");

 foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
$_SESSION['code']=$url;
 $result=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code='".$url."' LIMIT 1");
 $row=mysqli_fetch_assoc($result);
 echo '<div class="modal-header">
         
          <h3 class="modal-title"><center>UPDATE TRAINING</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<label>TITLE OF TRAININGS / ACTIVITIES:</label>
		<textarea name="TTitle" class="form-control" rows="3" required autofocus>'.$row['Title_of_training'].'</textarea>
		
		<label>FROM:</label>
		<input type="date" name="TFrom" class="form-control" value="'.$row['covered_from'].'" required>
		<label>TO:</label>
		<input type="date" name="TTo" class="form-control" value="'.$row['covered_to'].'" required>
		<label>CONDUCTED BY:</label>
		<select name="TConduct" class="form-control">
		<option value="">'.$row['conducted_by'].'</option>
		<option value="DepEd-City">DepEd City </option>
		<option value="DepEd-Region">DepEd Region</option>
		<option value="DepEd-Region">DepEd Central</option>
		</select>
		<label>VENUE:</label>
		<input type="text" name="TVenue" class="form-control" value="'.$row['TVenue'].'" required>
		
		</div>
		 <div class="modal-footer">
		 
		<input type="submit" name="update-data" Value="UPDATE" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();" >Close</button>
		</div>
		</form>';
?>		