<?php
include("../_includes_/function.php");
?>

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
<h4 class="modal-title" id="myModalLabel">Transaction Details</h4>
</div>
<div style="margin:15px;">
<?php
date_default_timezone_set("Asia/Manila");
$dateposted = date("Y-m-d H:i:s");
$data=mysqli_query($con,"SELECt * FROM tbl_transactions WHERE TransCode='".$_GET['id']."' LIMIT 1");
$row=mysqli_fetch_assoc($data);
$_SESSION['TranCode']= $_GET['id'];
echo '<h4>Transaction Code: '.$_GET['id'].'</h4>';
echo '<h4>Description: '.$row['Title'].'</h4>';
echo '<h4>From: '.$row['Trans_from'].'</h4>';
echo '<h4>Transaction Status: '.$row['Trans_Stats'].'</h4>';
echo '<h4>Date & Time: '.$dateposted.'</h4>';
?>
</div>
<form action="transactions.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST">
        <div class="modal-body">
           <label style="padding:4px;">Destination (Select Section)</label><br/>
		   <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="SUPPLY" required> SUPPLY
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="BAC" required> BAC
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
                        <input type="radio" name="officeTo" value="RECORD" required> RECORD
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
                         <input type="radio"  name="officeTo" value="BUDGET" required> BUDGET
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="PSDS" required> PSDS
                    </label>
					 <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="HRMO" required> HRMO
                    </label>        
            </div>
			<label>Select Transaction Status</label>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="status" value="For signature" required> For signature
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Approval" required> For Approval
                    </label>
					<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For reproduction" required> For reproduction
                </label> 
                  <label class="checkbox-inline">
                      <input type="radio"  name="status" value="On Process" required> On Process
                </label> 
            </div>
			
			<hr/>
			<input type="submit" name="submit" value="SUBMIT" class="btn btn-primary">
</div>
</form>
                                       