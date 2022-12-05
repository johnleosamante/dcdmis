<?php
session_start();
foreach ($_GET as $key => $data)
{
$id=$_GET[$key]=base64_decode(urldecode($data));	
}
$_SESSION['PicNo']=$id;
?>
<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Update HE Laboratory</h4>
			</div>
			<form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
		 		
				<input type="file" name="picture"  style="cursor:pointer;" onchange="loadFile(event)" required>
				
		</div>
            <div class="modal-footer">                           
			<input type="submit" name="update_library" value="Save" style="cursor:pointer;" class="btn btn-primary">
			</div>
			</form>	
                             