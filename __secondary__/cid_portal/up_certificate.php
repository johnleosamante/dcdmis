  <?php
  session_start();
  include("../../pcdmis/vendor/jquery/function.php");
   foreach ($_GET as $key => $data)
		{
		$url=$_GET[$key]=base64_decode(urldecode($data));
			
		}
	$_SESSION['code']=	$url;
	$result=mysqli_query($con,"SELECT * FROM tbl_speaker_seminar WHERE SpkCode='".$url."' AND SpkSeminar='".$_SESSION['Training_Code']."' LIMIT 1");
	$row=mysqli_fetch_assoc($result);
	$_SESSION['code']=	$url;
	$_SESSION['spkname']=	$row['SpkName'];
	
  ?>
  <form action="" method="POST" enctype="multipart/form-data">
  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>PERSONNEL ACCOUNT</center></h3>
		
        </div>
        <div class="modal-body">
		<?php
		  echo '<h4>Speaker Name: '.$row['SpkName'].'</h4>';
		 ?>
		<input type="file" name="certificate" onchange="loadFile1(event)" required>
		  <img src="" style="width:100%;height:300px;padding:4px;margin:4px;" id="pic1"><hr/>
		  <input type="submit" name="update_training" value="CHANGE" class="btn btn-primary">
		</div>
</form>
		