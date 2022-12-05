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
                         <input type="radio"  name="officeTo" value="OSDS" required> OSDS
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
                        <input type="radio" name="officeTo" value="RECORD" required> RECORD
                    </label>
					
                              
            </div>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="PHYSICAL" required> PHYSICAL FACILITIES
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="ACCOUNTING" required> ACCOUNTING
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="PSDS" required> PSDS
                    </label>
					 <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="HRMO" required> HRMO
                    </label>   
				 					
            </div>
			<hr/>
			<label>Select Transaction Status</label>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="status" value="For signature" required onclick="view_remark(this.value);"> For signature
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Evaluation" required onclick="view_remark(this.value);"> For Evaluation
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Issuance of check" required onclick="view_remark(this.value);"> For Issuance of check
                    </label>
					    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For SLIIAE" required onclick="view_remark(this.value);"> For SLIIAE
                    </label>    
            </div>
			<div class="form-group">
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="In-Complete" onclick="view_remark(this.value);" required> In-Complete
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For Obligation" required onclick="view_remark(this.value);"> For Obligation
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" id="status" value="Return to Sender" required onclick="view_remark(this.value);"> Return to Sender
					  <input type="hidden" id="remark">
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" id="status" value="Canceled" required onclick="view_remark(this.value);"> Canceled
					  <input type="hidden" id="remark">
                </label> 
				
			</div>	
			<div class="form-group">
			<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For ADA Prooflist" required onclick="view_remark(this.value);"> For ADA Prooflist
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For Payment" required onclick="view_remark(this.value);"> For Payment
                </label> 
				
			</div>	
			<textarea name="transfinding" id="myfinding" cols="75%" rows="2%" disabled></textarea>
			</div>
		<div class="modal-footer">
		<input type="submit" name="Released" value="Confirm" class="btn btn-primary">
      <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">Close</button>
		</form>
</div>
<script>
	function  view_remark()
	{
	   document.getElementById("myfinding").disabled=false;
	   document.getElementById("myfinding").focus();
	}	
</script>                              
<script>
	function  set_disabled()
	{
	   document.getElementById("myfinding").disabled=true;
	}	
</script>  