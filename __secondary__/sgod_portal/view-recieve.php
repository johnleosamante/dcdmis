<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
$url=$_GET[$key]=base64_decode(urldecode($data));
	
}
if($_SESSION['uid']=="")
		{
			header('location:https://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$_SESSION['Transcode']=$url;
?>


<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
<h4 class="modal-title" id="myModalLabel">Transaction Details</h4>
</div>
<form action=""	Method="POST" enctype="multipart/form-data">
	
<div style="margin:15px;">

<?php
	$query=mysqli_query($con,"SELECt * FROM tbl_transactions WHERE TransCode='".$url."' LIMIT 1");
	$row=mysqli_fetch_assoc($query);
	echo '<h4>Title: '.$row['Title'].'</h4>';
	echo '<h4>From: '.$row['Trans_from'].'</h4>';
	echo '<h4>Status: '.$row['Trans_Stats'].'</h4><hr/>';
?>
</div>
        <div class="modal-body">
		
		<input type="submit" name="Recieve" value="Receive" class="btn btn-primary">
      
		</form>
</div>
                                       
                                       