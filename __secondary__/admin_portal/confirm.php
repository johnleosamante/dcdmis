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
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
<h4 class="modal-title" id="myModalLabel">Transaction Details</h4>
</div>
<form action=""	Method="POST" enctype="multipart/form-data">
	
<div style="margin:15px;">

<?php
	$query=mysqli_query($con,"SELECt * FROM tbl_transactions WHERE TransCode='". $_GET['id']."' LIMIT 1");
	$row=mysqli_fetch_assoc($query);
	echo '<h4>Title: '.$row['Title'].'</h4>';
	echo '<h4>From: '.$row['Trans_from'].'</h4>';
	echo '<h4>Status: '.$row['Trans_Stats'].'</h4>';
?>
</div>
        <div class="modal-body">
		
			<label>Select Transaction Status</label>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="status" value="For signature" required onclick="viewdata(this.value)"> For signature
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Evaluation" required onclick="viewdata(this.value)"> For Evaluation
                    </label>
                   
					    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For release" required onclick="viewdata(this.value)"> For release
                    </label>    
            </div>
			<div class="form-group">
				
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For Investigation" required onclick="viewdata(this.value)"> For Investigation
                </label> 
				<label class="checkbox-inline">
                         <input type="radio"  name="status" value="Canceled" required onclick="viewdata(this.value)"> Canceled
                    </label>  
			<label class="checkbox-inline">
                         <input type="radio"  name="status" value="ITO Copy" required onclick="viewdata(this.value)"> ITO Copy
                    </label>  					
			</div>	
		<div id="destination"></div>		
</div>
<div class="modal-footer">
<input type="submit" name="Released" value="Confirm" class="btn btn-primary">
 <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">Close</button>     
		</form>