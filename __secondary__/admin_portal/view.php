<?php
session_start();
include("../vendor/jquery/function.php");
echo '<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
		<div class="modal-body">
		<iframe src="'.$_GET['id'].'" width="100%" height="550px"></iframe>
      </div>
	 ';
?>