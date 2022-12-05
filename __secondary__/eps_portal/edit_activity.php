  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>UPDATE ACTIVITY</center></h3>
		
        </div>
        <div class="modal-body">
		<form action="list_of_activity.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST">
		<?php
		session_start();
		include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$_SESSION['code']=$_GET['code'];
		$updata=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Training_Code='".$_GET['code']."' LIMIT 1");
	   $row=mysqli_fetch_assoc($updata);
	   echo '<label>TRAININGS CODE:</label>
		<input type="text" name="Tcode" class="form-control" value="'.$_GET['code'].'" required disabled>
		<label>TITLE OF TRAININGS / ACTIVITIES:</label>
		<textarea name="TTitle" class="form-control" rows="3" required>'.$row['Title_of_training'].'</textarea>
		
		<label>FROM:</label>
		<input type="date" name="TFrom" class="form-control" value="'.$row['covered_from'].'" required>
		<label>TO:</label>
		<input type="date" name="TTo" class="form-control" value="'.$row['covered_to'].'" required>
		
		<label>VENUE:</label>
		<input type="text" name="TVenue" class="form-control" value="'.$row['TVenue'].'" required>';
		
		?><hr/>
		 <input type="submit" class="btn btn-primary" name="update_training" value="SUBMIT">
		</form> 
</div>
