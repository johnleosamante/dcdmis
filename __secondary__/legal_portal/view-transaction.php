<?php
session_start();
include("../vendor/jquery/function.php");
?>

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
<h4 class="modal-title" id="myModalLabel">Transaction Details</h4>
</div>
<div style="margin:15px;">
<?php
$data=mysqli_query($con,"SELECt * FROM tbl_transactions WHERE TransCode='".$_GET['id']."' LIMIT 1");
$row=mysqli_fetch_assoc($data);
$_SESSION['TranCode']= $_GET['id'];
echo '<h4>Transaction Code:<b> '.$_GET['id'].'</b></h4>';
echo '<h4>Description: <b>'.$row['Title'].'</b></h4>';
echo '<h4>From: <b>'.$row['Trans_from'].'</b></h4><hr/>';
?>
</div>
<form action="transactions.php?link=b65d14a30bd76c1c7355c4dde7773181724cda4c" Method="POST">
        <div class="modal-body">
           <label style="padding:4px;">Forwarded to:</label><br/>
		  <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="SGOD" required> SGOD
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="CID" required> CID
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="BUDGET" required> BUDGET
                    </label>
					<label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="SUPPLY" required> SUPPLY
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="CASHIER" required> CASHIER
                    </label>
					 <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="ITO" required> ITO
                    </label>
                    
            </div>
			<div class="form-group">
                    <label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="ACCOUNTING" required> ACCOUNTING
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="RECORDS" required> RECORDS
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="officeTo" value="LRMDS" required> LRMDS
                    </label>
					<label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="OSDS" required> OSDS
                    </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="officeTo" value="HEALTH" required> HEALTH
                    </label>                
            </div> <hr/>
			<input type="submit" name="submit" value="SUBMIT" class="btn btn-primary">
</div>
</form>
                                       