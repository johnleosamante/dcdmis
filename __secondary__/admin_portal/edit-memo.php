<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Update Memos</center></h3>
		  	
        </div>
		<form action="update-memo.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST" ENCTYPE="multipart/form-data">
        <div class="modal-body">
		<?php
		session_start();
		include("../vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$mypost=mysqli_query($con,"SELECT * FROM tbl_memos WHERE tbl_memos.FileCode='".$_GET['id']."' LIMIT 1");
		$row=mysqli_fetch_assoc($mypost);
		$_SESSION['No']=$_GET['id'];
		echo '<label>Date Posted: </label>
		<input type="text" class="form-control" value="'.$row['Date_uploaded'].'" disabled>
		<label>Post Details: </label>
		<textarea class="form-control" name="message" rows="5" required>'.$row['Filename'].'</textarea>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="update_post" Value="UPDATE" class="btn btn-success">';
		?>
		</div>
		</form>