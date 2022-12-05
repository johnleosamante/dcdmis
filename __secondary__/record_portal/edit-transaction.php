	<style>
	th{
		text-transform:uppercase;
	}
	</style>
<div class="col-lg-12">
<h3></h3>
</div>
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	
							<?php
							echo '<h4>Update Transactions</h4>';
                    
							if (isset($_POST['update_trans']))
							{
								mysqli_query($con,"UPDATE tbl_transactions SET Title='".$_POST['Qualname']."' WHERE TransCode='".$_SESSION['Trancode']."' LIMIT 1");
								mysqli_query($con,"UPDATE tbl_transactions_log SET Forwarded_to='".$_POST['first']."' WHERE Transaction_code='".$_SESSION['Trancode']."' LIMIT 1");
							
							
							
							if (mysqli_affected_rows($con)==1)
							{
							?>
									<script type="text/javascript">
									$(document).ready(function(){						
										 $('#verifier').modal({
											show: 'true'
										}); 				
									});
									</script>
									
							 
									<?php   
							}
							}
							?>
                        </div>
                        
                        <!-- /.panel-heading -->
						<form action="" Method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                           <?php
						   $_SESSION['Trancode']=$_GET['id'];
		$data=mysqli_query($con,"SELECT * FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='".$_GET['id']."' LIMIT 1");
		$row=mysqli_fetch_assoc($data);
		echo '
        
		<label>Transaction Details</label>
		<textarea name="Qualname"  class="form-control" rows="5" required>'.$row['Title'].'</textarea>
		<label style="padding:4px;">Destination (Select Section)</label><br/>
		 <div class="row">
				
		  <div class="col-lg-4">
				<label>1st Destination</label><br/>
				<select name="first" class="form-control" required>
				<option value="">--select--</option>';
				
				$destiny1=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row1=mysqli_fetch_array($destiny1))
				{
					echo '<option value="'.$row1['Offices'].'">'.$row1['Offices'].'</option>';
				}
				
				echo '</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>2nd Destination</label><br/>
				 <select name="second" class="form-control">
				<option value="">--select--</option>';
				
				$destiny2=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row2=mysqli_fetch_array($destiny2))
				{
					echo '<option value="'.$row2['Offices'].'">'.$row2['Offices'].'</option>';
				}
				
				echo 
					'</select>
				</div>
				
				<div class="col-lg-4">
				 <label>3rd Destination</label><br/>
				<select name="third" class="form-control">
				<option value="">--select--</option>';
				
				$destiny3=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row3=mysqli_fetch_array($destiny3))
				{
					echo '<option value="'.$row3['Offices'].'">'.$row3['Offices'].'</option>';
				}
				echo 
				'</select>
				
				</div>
			
	
			 <div class="col-lg-4">
				<label>4th Destination</label><br/>
				<select name="fourth" class="form-control">
				<option value="">--select--</option>';
				
				$destiny4=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row4=mysqli_fetch_array($destiny4))
				{
					echo '<option value="'.$row4['Offices'].'">'.$row4['Offices'].'</option>';
				}
				echo '
				</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>5th Destination</label><br/>
				 <select name="fifth" class="form-control">
				<option value="">--select--</option>';
				
				$destiny5=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row5=mysqli_fetch_array($destiny5))
				{
					echo '<option value="'.$row5['Offices'].'">'.$row5['Offices'].'</option>';
				}
				echo '
				</select>
				</div>
				
				<div class="col-lg-4">
				 <label>6th Destination</label><br/>
				<select name="six" class="form-control">
				<option value="">--select--</option>';
				
				$destiny6=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row6=mysqli_fetch_array($destiny6))
				{
					echo '<option value="'.$row6['Offices'].'">'.$row6['Offices'].'</option>';
				}
				echo '
				</select>
				
				</div>
				</div>
				
			<hr/>
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
			</div>
			<div class="modal-footer">
			<input type="submit" name="update_trans" value="UPDATE" class="btn btn-primary">
		      <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transaction")).'" class="btn btn-secondary" style="float:right;">Back</a>
							
			
			</div>	
			</form>
			</div>	
			
				';
		?>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
               
