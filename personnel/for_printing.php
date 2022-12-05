<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$_SESSION['TCode']=$_GET['code'];
?>
<form action="done.php" Method="POST">
<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
          <h4 class="modal-title"><center>Print ERF Application</center></h4>
		 
			<input type="submit"  class="btn btn-success" value="Done Printing" style="float:right;">

        </div>
        <div class="modal-body">
			<iframe src="print_erf.php" width="100%" height="550">
		</div>

</form>	
		