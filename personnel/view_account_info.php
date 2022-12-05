 <?php
 session_start();
include("../pcdmis/vendor/jquery/function.php");
$_SESSION['curticket']=$_GET['id'];
$result=mysqli_query($con,"SELECT * FROM tbl_deped_reset_account INNER JOIN tbl_deped_reset_account_logs ON tbl_deped_reset_account.TicketNo= tbl_deped_reset_account_logs.TicketNo WHERE tbl_deped_reset_account.TicketNo='".$_GET['id']."' LIMIT 1");
$row=mysqli_fetch_assoc($result); 
 echo '<div class="modal-header">
        
          <h3 class="modal-title"><center>REQUEST INFORMATION</center></h3>
		 
        </div>
		
        <div class="modal-body">
		 <label>Email Address:</label>
			<input type="email" value="'.$row['depedemail'].'" class="form-control" disabled>
		 <label>Temporary Password:</label>
			<input type="text" name="tempPassword" value="'.$row['TempPassword'].'" class="form-control" required placeholder="Temporary Password" disabled>
		 
		</div>
		<div class="modal-footer">
		
		 <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>
	   ';
?>	   