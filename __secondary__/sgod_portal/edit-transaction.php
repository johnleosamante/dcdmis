	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	
							<?php
							echo'<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transaction")).'" class="btn btn-success" style="float:right;">Back</a>
							<h4>Update Transactions</h4>';
                    
							if (isset($_POST['update_trans']))
							{
								mysqli_query($con,"UPDATE tbl_transactions SET Title='".$_POST['Qualname']."' WHERE TransCode='".$_SESSION['Trancode']."' LIMIT 1");
								mysqli_query($con,"UPDATE tbl_transactions_log SET Forwarded_to='".$_POST['first']."' WHERE Transaction_code='".$_SESSION['Trancode']."' LIMIT 1");
								mysqli_query($con,"UPDATE tbl_transaction_flow SET Destination_section='".$_POST['first']."' WHERE TransactionCode='".$_SESSION['Trancode']."' LIMIT 1");
							
							
							$Err = "Transaction Successfully Updated!";
									echo '<script type="text/javascript">
										$(document).ready(function(){						
										$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
										});</script>
										';	
								echo '<div class="alert alert-success">'.$Err.'</div>';	
								$_SESSION['Trancode']="";
							
							}
							?>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <?php
						   $_SESSION['Trancode']=$_GET['id'];
									$data=mysqli_query($con,"SELECT * FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode = tbl_transactions_log.Transaction_code WHERE tbl_transactions.TransCode='".$_GET['id']."' LIMIT 1");
									$row=mysqli_fetch_assoc($data);
									echo '<form action="" Method="POST" enctype="multipart/form-data">
									
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
													 <input type="radio"  name="status" value="For Appropriate Action" required > For Appropriate Action
												</label>
												   
										</div>
										<div class="form-group">
											 
											<label class="checkbox-inline">
												  <input type="radio"  name="status" value="For reproduction" required > For reproduction
											</label> 
											<label class="checkbox-inline">
												  <input type="radio"  name="status" id="status" value="For Investigation " required > For Investigation 
												  
											</label> 
											<label class="checkbox-inline">
												  <input type="radio"  name="status" value="For Memo Numbering" required> For Memo Numbering
											</label> 
											</div>
											<div class="form-group">
											 <label class="checkbox-inline">
													 <input type="radio"  name="status" value="For comments and recommendations" required > For comments and recommendations
												</label>    
											
										
										</div>	
										
										
											<input type="submit" name="update_trans" value="UPDATE" class="btn btn-primary">
									</form>';
									?>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               
