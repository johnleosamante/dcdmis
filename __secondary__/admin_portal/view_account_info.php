 <?php
 session_start();
include("../../pcdmis/vendor/jquery/function.php");
$_SESSION['curticket']=$_GET['id'];
$result=mysqli_query($con,"SELECT * FROM tbl_deped_reset_account WHERE TicketNo='".$_GET['id']."' LIMIT 1");
$row=mysqli_fetch_assoc($result); 
 echo '<div class="modal-header">
        
          <h3 class="modal-title"><center>REQUEST INFORMATION</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		 <label>Email Address:</label>
			<input type="email" value="'.$row['depedemail'].'" class="form-control" disabled>
		 <label>Temporary Password:</label>
			<input type="text" name="tempPassword" class="form-control" required placeholder="Temporary Password">
		 <label>Action Taken:</label>
         <select name="actiontaken" class="form-control" required>		
			<option value="">--Select--</option>
			<option value="Created">Created</option>
			<option value="Resited">Resited</option>
		 </select>		 
		</div>
		<div class="modal-footer">
		<input type="submit" name="saverequest" value="SUBMIT" class="btn btn-primary">
		 <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
	   </form>';
?>	   