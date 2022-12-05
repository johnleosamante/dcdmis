<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
if($_SESSION['uid']=="")
		{
			header('location:https://'.$_SERVER['HTTP_HOST'].'/pcdmis');
		}
		$_SESSION['Transcode']=$_GET['id'];
?>

<div class="modal-header">

<h4 class="modal-title" id="myModalLabel">Transaction Details</h4>
</div>
<form action=""	Method="POST" enctype="multipart/form-data">
	
<div style="margin:15px;">

<?php
	$query=mysqli_query($con,"SELECt * FROM tbl_transactions WHERE TransCode='". $_GET['id']."' LIMIT 1");
	$row=mysqli_fetch_assoc($query);
	echo '<h4>Title: '.$row['Title'].'</h4>';
	echo '<h4>From: '.$row['Trans_from'].'</h4>';
	echo '<h4>Status: '.$row['Trans_Stats'].'</h4><hr/>';
?>
</div>
        <div class="modal-body">
		<div style="float:right;">
          <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="ITO COPY "> ITO COPY 
                    </label>
                   
            </div>
		</div>
		<input type="submit" name="Recieve" value="Receive" class="btn btn-primary">
      <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">Close</button>
		</form>
</div>
                                       