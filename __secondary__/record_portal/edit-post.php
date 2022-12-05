<div class="modal-header">
          
          <h3 class="modal-title"><center>Update Communication</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		session_start();
	include("../../pcdmis/vendor/jquery/function.php");
		if($_SESSION['uid']=="")
		{
			header('location:http://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$mypost=mysqli_query($con,"SELECT * FROM tbl_communication WHERE MemoNo='".$_GET['id']."' LIMIT 1");
		$row=mysqli_fetch_assoc($mypost);
		$_SESSION['MemoNo']=$_GET['id'];
		echo '<label>Date Posted: </label>
		<label>Date Post: </label>
		<input type="text" class="form-control" value="'.$row['Date_created'].'" disabled>
		<label>Memo Details: </label>
		<textarea class="form-control" name="message" rows="5" required>'.$row['Memo_Details'].'</textarea>
		<label>Communication Source: </label>
		<select name="source" class="form-control">
			<option value="'.$row['sourch_memo'].'">'.$row['sourch_memo'].'</option>
			<option value="Regional Memo">Regional Memo</option>
			<option value="Central Memo">Central Memo</option>
			<option value="LGU">LGU</option>
			<option value="Others">Others</option>
		</select>
		<label>Office Destination: </label>
		<select name="offices" class="form-control">
			<option value="'.$row['office_destination'].'">'.$row['office_destination'].'</option>
			<option value="SGOD">SGOD</option>
			<option value="CID">CID</option>
			<option value="OSDS">OSDS</option>
			
		</select>
		</div>
		 <div class="modal-footer">
		<input type="submit" name="update_communication" Value="UPDATE" class="btn btn-success">
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>';
		?>
		</div>
		</form>