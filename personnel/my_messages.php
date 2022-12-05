  <?php
  session_start();
include("../pcdmis/vendor/jquery/function.php");
  mysqli_query($con,"UPDATE tbl_messages SET Message_status='Read' WHERE No='".$_GET['id']."'");
  
  echo '<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
		  <h3 class="modal-title"><center>Message Information</center></h3>
        </div>
        <div class="modal-body">
		<h4>You are qualified for Step Increment!! </h4>
		<h4>To confirm please visit HRMO.. </h4>
		<a href="" class="btn btn-success">OK</a>
		
		</div>';
	?>	
	
	
