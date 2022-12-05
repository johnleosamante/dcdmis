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
	date_default_timezone_set("Asia/Manila");
	echo '<h4>Title: '.$row['Title'].'</h4>';
	echo '<h4>From: '.$row['Trans_from'].'</h4>';
	echo '<h4>Status: '.$row['Trans_Stats'].'</h4>';
	echo '<h4>Date & Time: '.date("Y-m-d H:i:s").'</h4><hr/>';
	$_SESSION['From']=$row['Trans_from'];
?>
</div>
        <div class="modal-body">
	<label>Destination (Select Sections)</label>
           <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="SUPPLY" required> SUPPLY
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="SGOD" required> SGOD
                    </label>
                    
					<label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="LEGAL" required> LEGAL
                    </label>
                    
					 <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="ITO" required> ITO
                    </label>
					 <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="RECORD" required> RECORD
                    </label>
                     <label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="BAC" required> BAC
                    </label>  
            </div>
			<div class="form-group">
					<label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="ASDS" required> ASDS
                    </label>
					<label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="CASHIER" required> CASHIER
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="CID" required> CID
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="LRMDS" required> LRMDS
                    </label>
					<label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="ACCOUNTING" required> ACCOUNTING
                    </label>
                              
            </div>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="PHYSICAL" required> PHYSICAL FACILITIES
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="OSDS" required> OSDS
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="PSDS" required> PSDS
                    </label>
					 <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="HRMO" required> HRMO
                    </label> 
					<label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="BUDGET" required> BUDGET
                    </label> 					
            </div>
			<hr/>  
		<label>Select Transaction Status</label>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="status" value="For signature" required> For signature
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Evaluation" required> For Evaluation
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="Return" required> Return
                    </label>
					       
            </div>
			<div class="form-group">
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For reproduction" required> For reproduction
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For Investigation" required> For Investigation
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="SGOD Copy" required> SGOD Copy
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For release" required> For release
                </label> 
			</div>	
		<input type="submit" name="Released" value="Released" class="btn btn-primary">
      
		</form>
</div>
                                       