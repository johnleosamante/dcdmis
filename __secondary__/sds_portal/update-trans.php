<?php
include("../_includes_/function.php");
$_SESSION['Trancode']=$_GET['id'];
?>

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">&times;</button>
<h4 class="modal-title" id="myModalLabel">Update Transaction</h4>
</div>
<div style="margin:15px;">

</div>
        <div class="modal-body">
		<?php
		$data=mysqli_query($con,"SELECT * FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='".$_GET['Code']."' LIMIT 1");
		$row=mysqli_fetch_assoc($data);
		$_SESSION['No']=$_GET['id'];
		$_SESSION['TransCode']=$_GET['Code'];
		
		echo '<form action="" Method="POST" enctype="multipart/form-data">
         <label>Transaction Code</label>
		<input type="text" class="form-control" value="'.$_GET['Code'].'"disabled>
		<label>Transaction Details</label>
		<textarea name="Qualname"  class="form-control" rows="5" required>'.$row['Title'].'</textarea>
		<label style="padding:4px;">Destination (Select Section)</label><br/>
		  <div class="form-group">
              <label class="checkbox-inline">';
					if ($row['Forwarded_to']=='SUPPLY')
					{
					echo '<input type="radio" name="officeTo" value="SUPPLY" required checked> SUPPLY';
						
					}else{
                    echo '<input type="radio" name="officeTo" value="SUPPLY" required> SUPPLY';
					}
                    echo '</label>
                    <label class="checkbox-inline">';
					if ($row['Forwarded_to']=='SGOD')
					{
					echo '<input type="radio" name="officeTo" value="SGOD" required checked> SGOD';
						
					}else{
                       echo '<input type="radio"  name="officeTo" value="SGOD" required> SGOD';
                    }
					echo '</label>
                    
					<label class="checkbox-inline">';
					if ($row['Forwarded_to']=='LEGAL')
					{
					echo '<input type="radio" name="officeTo" value="LEGAL" required checked> LEGAL';
						
					}else{
                       echo '<input type="radio" name="officeTo" value="LEGAL" required> LEGAL';
					}
                   echo '</label>
                    
					 <label class="checkbox-inline">';
					 if ($row['Forwarded_to']=='ITO')
					{
					echo '<input type="radio" name="officeTo" value="ITO" required checked> ITO';
						
					}else{
                       echo '
                         <input type="radio"  name="officeTo" value="ITO" required> ITO';
					} 
                    echo '</label>
					 <label class="checkbox-inline">';
					  if ($row['Forwarded_to']=='SDS')
					{
					echo '<input type="radio" name="officeTo" value="SDS" required checked> SDS';
						
					}else{
                       echo '
                         <input type="radio"  name="officeTo" value="SDS" required> SDS';
					}	 
                    echo '</label>
                    <label class="checkbox-inline">';
					 if ($row['Forwarded_to']=='ASDS')
					{
					echo '<input type="radio" name="officeTo" value="ASDS" required checked> ASDS';
						
					}else{
                       
                       echo ' <input type="radio" name="officeTo" value="ASDS" required> ASDS';
					}	
                   echo ' </label>
            </div>
			<div class="form-group">
					<label class="checkbox-inline">';
					
                    if ($row['Forwarded_to']=='CASHIER')
					{
					echo '<input type="radio" name="officeTo" value="CASHIER" required checked> CASHIER';
						
					}else{
                       
                       echo ' <input type="radio"  name="officeTo" value="CASHIER" required> CASHIER';
					} 
                   echo  '</label>
                    
                    <label class="checkbox-inline">';
					
                     if ($row['Forwarded_to']=='BAC')
					{
					echo '<input type="radio" name="officeTo" value="BAC" required checked> BAC';
						
					}else{
                       
                       echo '  <input type="radio"  name="officeTo" value="BAC" required> BAC';
					} 
                    echo '</label>
                    <label class="checkbox-inline">';
					
                          if ($row['Forwarded_to']=='LRMDS')
					{
					echo '<input type="radio" name="officeTo" value="LRMDS" required checked> LRMDS';
						
					}else{
                       
                       echo '<input type="radio"  name="officeTo" value="LRMDS" required> LRMDS';
					} 
                    echo '</label>
					<label class="checkbox-inline">';
					
                    if ($row['Forwarded_to']=='ACCOUNTING')
					{
					echo '<input type="radio" name="officeTo" value="ACCOUNTING" required checked> ACCOUNTING';
						
					}else{
                       
                       echo '<input type="radio" name="officeTo" value="ACCOUNTING" required> ACCOUNTING';
					}
					   
                   echo '</label>
                       <label class="checkbox-inline">';
					   
                        if ($row['Forwarded_to']=='CID')
					{
					echo '<input type="radio" name="officeTo" value="CID" required checked> CID';
						
					}else{
                       
                       echo ' <input type="radio" name="officeTo" value="CID" required> CID';
					} 
                    echo '</label>          
            </div>
			<div class="form-group">
					<label class="checkbox-inline">';
					
                   if ($row['Forwarded_to']=='PHYSICAL')
					{
					echo '<input type="radio" name="officeTo" value="PHYSICAL" required checked> PHYSICAL FACILITIES';
						
					}else{
                       
                       echo '<input type="radio"  name="officeTo" value="PHYSICAL" required> PHYSICAL FACILITIES';
					}
                    echo '</label>
                    
                    <label class="checkbox-inline">';
					
                        if ($row['Forwarded_to']=='BUDGET')
					{
					echo '<input type="radio" name="officeTo" value="BUDGET" required checked> BUDGET';
						
					}else{
                       
                       echo ' <input type="radio"  name="officeTo" value="BUDGET" required> BUDGET';
					}
                    echo '</label>
                    <label class="checkbox-inline">';
					
                         
                    echo '</label>
					 <label class="checkbox-inline">';
					  if ($row['Forwarded_to']=='HRMO')
					{
					echo '<input type="radio" name="officeTo" value="HRMO" required checked> HRMO';
						
					}else{
                       
                       echo '
                         <input type="radio"  name="officeTo" value="HRMO" required> HRMO';
					}	 
                    echo '</label>    
				<label class="checkbox-inline">';
					  if ($row['Forwarded_to']=='RECORD')
					{
					echo '<input type="radio" name="officeTo" value="RECORD" required checked> RECORD';
						
					}else{
                       
                       echo '
                         <input type="radio"  name="officeTo" value="RECORD" required> RECORD';
					}	 
                    echo '</label>    					
            </div>
			<label>Select Transaction Status</label>
			<div class="form-group">
					<label class="checkbox-inline">
                         <input type="radio"  name="status" value="For signature" required > For signature
                    </label>
                    
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Evaluation" required > For Evaluation
                    </label>
                    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For reproduction" required > For reproduction
                    </label>
					    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For release" required > For release
                    </label>    
            </div>
			<div class="form-group">
				
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For Investigation" required onclick="set_disabled(this.value);"> For Investigation
                </label> 
				<label class="checkbox-inline">
                         <input type="radio"  name="status" value="Canceled" required > Canceled
                    </label>  
			<label class="checkbox-inline">
                         <input type="radio"  name="status" value="SDS Copy" required > SDS Copy
                    </label>  
<label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Approval" required > For Approval
                    </label>  
					
			</div>
			<hr/>
				<input type="submit" name="uptrans" value="UPDATE" class="btn btn-primary">
		</form>';
		?>
		</div>
                                       