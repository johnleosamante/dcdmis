
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <a href="#newtrack" class="btn btn-primary" style="float:right;" data-toggle="modal">New Transaction</a>
							<h4>Transactions History</h4>
							<?php
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							if (isset($_POST['new_transaction']))
							{
								$dataA=$_POST['Qualname'];
								$dataA=str_replace("'","\'",$dataA);						
								mysqli_query($con,"INSERT INTO tbl_transactions VALUES ('".$_POST['Qualicode']."','".$dataA	."','".$dateposted."','PSDS','".$_POST['status']."','Unread','123131','')");
								if (mysqli_affected_rows($con)==1)
								{
									mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES (NULL,'".$dateposted."','".$_SESSION['uid']."','PSDS','".$_POST['first']."','".$_POST['status']."','".$_POST['Qualicode']."','New')");
								if (isset($_POST['first']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'1','".$_POST['first']."','123131','".$_POST['Qualicode']."')");
		
								 }
								 if (isset($_POST['second']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'2','".$_POST['second']."','123131','".$_POST['Qualicode']."')");

								 }
								  if (isset($_POST['third']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'3','".$_POST['third']."','123131','".$_POST['Qualicode']."')");

								 }
								  if (isset($_POST['fourth']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'4','".$_POST['fourth']."','123131','".$_POST['Qualicode']."')");

								 } if (isset($_POST['fifth']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'5','".$_POST['fifth']."','123131','".$_POST['Qualicode']."')");

								 } if (isset($_POST['six']))
								 {
									 mysqli_query($con,"INSERT INTO tbl_transaction_flow VALUES(NULL,'6','".$_POST['six']."','123131','".$_POST['Qualicode']."')");

								 }
								?>
									<script type="text/javascript">
									$(document).ready(function(){						
										 $('#access').modal({
											show: 'true'
										}); 				
									});
									</script>
									
							 
									<?php   
								}	
							}elseif (isset($_POST['update_trans']))
							{
								mysqli_query($con,"UPDATE tbl_transactions SET Title='".$_POST['Qualname']."' WHERE TransCode='".$_SESSION['Trancode']."' LIMIT 1");
								mysqli_query($con,"UPDATE tbl_transactions_log SET Forwarded_to='".$_POST['first']."' WHERE Transaction_code='".$_SESSION['Trancode']."' LIMIT 1");
							
							
							
							if (mysqli_affected_rows($con)==1)
							{
							?>
								<script type="text/javascript">
								$(document).ready(function(){						
									 $('#access').modal({
										show: 'true'
									}); 				
								});
								</script>
								
						 
								<?php   
								
							}
							}elseif (isset($_POST['Canceled']))
							{
								$remark="Canceled - ".$_POST['remarks'];
								mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='".$remark."' WHERE TransCode='".$_SESSION['Transcanceled']."' LIMIT 1");
							if (mysqli_affected_rows($con)==1)
							{
							mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES (NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','-','".$remark."','".$_SESSION['Transcanceled']."','Done')");
							
							?>
								<script type="text/javascript">
								$(document).ready(function(){						
									 $('#access').modal({
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
                        <div class="panel-body">
                            <?php
							$tot=$totm=$totf=0;
							
								echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="text-align:center;">#</th>
												<th width="15%">Transaction Code</th>
												<th>Description</th>
												<th style="text-align:center;" width="15%">Date Time Created</th>
												<th style="text-align:center;" width="15%">Status</th>
												<th width="5%"></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=0; 
										$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.Trans_from='".$_SESSION['station']."' ORDER BY Date_time Desc LIMIT 100");
											while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>';
													
													echo '<td>'.$row['TransCode'].'</td>';
													echo '<td>'.$row['Title'].'</td>';
													echo '
													<td style="text-align:center;">'.$row['Date_time'].'</td>
													<td style="text-align:center;">'.$row['Trans_Stats'].'</td>
													<td style="text-align:center;">';
														if ($row['Trans_Stats']=='Completed' || $row['Trans_Stats']=='COMPLETED')
														{
														 echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("quatame")).'" title="QUATAME"> Evaluation</a>';
														}else{
														  echo '<a href="print-transaction.php?link='.sha1("Deped Data Management System v.1.0").'&&Code='.urlencode(base64_encode($row['TransCode'])).'" target="_blank" title="Print Transaction"> Print</a><br/>';		
														}
														echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("view_log")).'" title="View Transaction Logs"> View</a>
																<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("update_transaction")).'" title="Update Transaction"> Update</a>
																
																<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("canceled_transaction")).'" title="Cancelled Transaction"> Canceled</a>';
												
													echo '</td>
														
														
											</tr>';
										}
										
										
										echo '</tbody>
									</table>';
						
							
							
							?>
                                </tbody>
                            </table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               

   <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="newtrack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
        
          <h3 class="modal-title"><center>New Transaction</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<?php
		$num=0;
		$code="";
		$result=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE Trans_from='".$_SESSION['station']."'");
		$num=mysqli_num_rows($result)+1;
		if ($num>=0 AND $num<=9)
		{
		$code=$_SESSION['station'].'-000'.$num;
		}elseif ($num>=10 AND $num<=99)
		{
		$code=$_SESSION['station'].'-00'.$num;
		}elseif ($num>=100 AND $num<=999)
		{
		$code=$_SESSION['station'].'-0'.$num;
		}elseif ($num>=1000)
		{
		$code=$_SESSION['station'].'-'.$num;
		}
		echo '<label>Transaction Code</label>
		<input type="text" class="form-control" value="'.$code.'"disabled>
		<input type="hidden" name="Qualicode"  class="form-control"  value="'.$code.'">';
		?><label>Transaction Description</label>
		<textarea name="Qualname"  class="form-control" rows="5" required></textarea>
		<label style="padding:4px;">Destination (Select Section)</label><br/>
		   <div class="row">
				
                <div class="col-lg-4">
				<label>1st Destination</label><br/>
				<select name="first" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny1=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row1=mysqli_fetch_array($destiny1))
				{
					echo '<option value="'.$row1['Offices'].'">'.$row1['Offices'].'</option>';
				}
				?>
				</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>2nd Destination</label><br/>
				 <select name="second" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny2=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row2=mysqli_fetch_array($destiny2))
				{
					echo '<option value="'.$row2['Offices'].'">'.$row2['Offices'].'</option>';
				}
				?>
				</select>
				</div>
				
				<div class="col-lg-4">
				 <label>3rd Destination</label><br/>
				<select name="third" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny3=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row3=mysqli_fetch_array($destiny3))
				{
					echo '<option value="'.$row3['Offices'].'">'.$row3['Offices'].'</option>';
				}
				?>
				</select>
				
				</div>
			
	
			 <div class="col-lg-4">
				<label>4th Destination</label><br/>
				<select name="fourth" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny4=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row4=mysqli_fetch_array($destiny4))
				{
					echo '<option value="'.$row4['Offices'].'">'.$row4['Offices'].'</option>';
				}
				?>
				</select>
				</div>
				
				 <div class="col-lg-4">
				 <label>5th Destination</label><br/>
				 <select name="fifth" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny5=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row5=mysqli_fetch_array($destiny5))
				{
					echo '<option value="'.$row5['Offices'].'">'.$row5['Offices'].'</option>';
				}
				?>
				</select>
				</div>
				
				<div class="col-lg-4">
				 <label>6th Destination</label><br/>
				<select name="six" class="form-control">
				<option value="">--select--</option>
				<?php
				$destiny6=mysqli_query($con,"SELECT * FROM tbl_deparment");
				while ($row6=mysqli_fetch_array($destiny6))
				{
					echo '<option value="'.$row6['Offices'].'">'.$row6['Offices'].'</option>';
				}
				?>
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
                         <input type="radio"  name="status" value="For Memo No" required > For Memo No
                    </label>
					    <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For Production" required > For Production
                    </label>    
            </div>
			<div class="form-group">
				 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For Obligation" required > For Obligation
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" id="status" value="For ADA Prooflist" required > For ADA Prooflist
					  
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" id="status" value="For Payment" required > For Payment
					  
                </label> 
			
			</div>	
			
			
		
			<div class="modal-footer">
		<input type="submit" name="new_transaction" value="SUBMIT" class="btn btn-primary">
		  <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
        </form>
		</div>
		</div>
		

		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign-->



						 
						 <div class="panel-body">
                            
                            <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="Mylog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
										
										
										
										
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        <!-- .panel-body -->