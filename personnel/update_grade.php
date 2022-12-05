 <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>UPDATE FINAL GRADE</center></h3>
		
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		session_start();
		include("../pcdmis/vendor/jquery/function.php");
		foreach ($_GET as $key => $data)
		{
		$code=$_GET[$key]=base64_decode(urldecode($data));	
		}
		$_SESSION['FGradeNo']=$_GET['code'];
		$mygrade=mysqli_query($con,"SELECT * FROM junior_tor WHERE SubNo='".$_GET['code']."' AND GradeNo='".$_SESSION['Grade_Level']."' AND SYCode='".$_SESSION['year']."' LIMIT 1");		
		$rowgrade=mysqli_fetch_assoc($mygrade);	
		
		echo '<label>Learning Areas:</label><label>'.$code.'</label><br/>';
        echo '<label>First:</label><input type="text" name="first" class="form-control" value="'.$rowgrade['First_Grade'].'">';
        echo '<label>Second:</label><input type="text" name="second" class="form-control" value="'.$rowgrade['Second_Grade'].'">';
        echo '<label>Third:</label><input type="text" name="third" class="form-control" value="'.$rowgrade['Third_Grade'].'">';
        echo '<label>Fourth:</label><input type="text" name="fourth" class="form-control" value="'.$rowgrade['Fourth_Grade'].'">';
					
				
		?>
		</div>
		<div class="modal-footer">
		<input type="submit" name="update_grade" class="btn btn-primary" value="SAVE">
		</div>
		</form>