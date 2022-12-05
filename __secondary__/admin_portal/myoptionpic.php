<?php
session_start();
foreach ($_GET as $key => $data)
{
$code=$_GET[$key]=base64_decode(urldecode($data));
	
}
$_SESSION['OpPic']=$code;
?>
<script>
	var loadFile = function(event) {
    var output = document.getElementById('pic');
    output.src = URL.createObjectURL(event.target.files[0]);
	};
	</script>
	
<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Picture for the Option <?php echo $code; ?></h4>
			</div>
			 <form action="" method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			<img src="" id="pic" style="width:100%;"><hr/>
			<input type="file" name="image" onchange="loadFile(event)" required>
		   	</div>
           <div class="modal-footer">
		   <button type="submit" class="btn btn-success" name="AddOption">ADD</button>
		 </div>	
		 </form>