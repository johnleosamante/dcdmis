<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Announcement</center></h3>
		  	
        </div>
		<form action="list_of_announcement.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST">
        <div class="modal-body">
		<?php
		session_start();
		include("../../pcdmis/vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$mypost=mysqli_query($con,"SELECT * FROM post WHERE post.chatID='".$_GET['id']."' LIMIT 1");
		$row=mysqli_fetch_assoc($mypost);
		$_SESSION['No']=$_GET['id'];
		echo '<label>Date Posted: </label>
		<input type="text" class="form-control" value="'.$row['date_posted'].'" disabled>
		<label>Post Details: </label>
		<textarea class="form-control" name="message" rows="5" required>'.$row['post_Title'].'</textarea>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="update_post" Value="UPDATE" class="btn btn-success">';
		?>
		</div>
		</form>