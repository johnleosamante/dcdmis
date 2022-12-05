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
							//echo ' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("newtransaction")).'" class="btn btn-primary" style="float:right;" >New Transaction</a>
							echo ' <a href="#newtran" class="btn btn-primary" style="float:right;" data-toggle="modal">New Transaction</a>
							<h4>Transactions History</h4>';
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							if (isset($_POST['new_transaction']))
							{
							$dataA=$_POST['Qualname'];
							$dataA=str_replace("'","\'",$dataA);
							mysqli_query($con,"INSERT INTO tbl_transactions VALUES ('".$_POST['Qualicode']."','".$dataA."','".$dateposted."','RECORD','".$_POST['status']."','Unread','123131','')");
						
							if (mysqli_affected_rows($con)==1)
								{
									mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES (NULL,'".$dateposted."','".$_SESSION['uid']."','RECORD','".$_POST['first']."','".$_POST['status']."','".$_POST['Qualicode']."','New')");
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
							}elseif(isset($_POST['search']))
							{
								//Number of Released
								$datareleased=mysqli_query($con,"SELECT * FROM tbl_transactions_log WHERE tbl_transactions_log.Forwarded_to='".$_SESSION['station']."' AND tbl_transactions_log.Date_recieved BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' AND tbl_transactions_log.Trans_status = 'For release'");
								echo '<label>Number of Released:'.mysqli_num_rows($datareleased).'</label><br/>';		
								
								//Number of Recieved
									$dataaproval=mysqli_query($con,"SELECT * FROM tbl_transactions_log WHERE tbl_transactions_log.Forwarded_to='".$_SESSION['station']."' AND tbl_transactions_log.Date_recieved BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'");
								echo '<label>Number of Recieve:'.mysqli_num_rows($dataaproval).'</label>';	
							}							
							
							?>			
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<form action="" method="POST">
						<label>FROM: <input type="date" name="from"></label>
						<label>TO: <input type="date" name="to"></label>
						<input type="submit" name="search" value="SEARCH">
						</form>
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
												<th width="10%"></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=0; 
										$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.Trans_from='".$_SESSION['station']."' AND tbl_transactions.Trans_Stats<>'Completed' ORDER BY tbl_transactions.Date_time Desc LIMIT 100");
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
														
														  echo '<a href="print-transaction.php?link='.sha1("Deped Data Management System v.1.0").'&&Code='.urlencode(base64_encode($row['TransCode'])).'" target="_blank" title="Print Transaction" class="btn btn-success" style="padding:4px;margin:4px;"> <i class="fa fa-print fa-fw"></i></a>';		
															echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("view_log")).'" title="View Transaction Logs" class="btn btn-info" style="padding:4px;margin:4px;"><i class="fa fa-desktop fa-fw"></i></a>
																<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("update_transaction")).'" title="Edit Transaction" class="btn btn-danger" style="padding:4px;margin:4px;"> <i class="fa fa-pencil fa-fw"></i></a>
																
																<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TransCode'])).'&v='.urlencode(base64_encode("canceled_transaction")).'" title="Cancelled Transaction" class="btn btn-warning" style="padding:4px;margin:4px;"> <i class="fa fa-trash fa-fw"></i></a>';
												
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
     <div class="modal fade" id="newtran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Transaction</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<?php
		$num=0;
		$code="";
		$result=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE Trans_from='".$_SESSION['station']."'");
		$num=mysqli_num_rows($result)+date("ydmmsi");
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
				<select name="first" class="form-control" required>
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
                         <input type="radio"  name="status" value="For Appropriate Action" required > For Appropriate Action
                    </label>
					   
            </div>
			<div class="form-group">
				 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" value="For reproduction" required > For reproduction
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" id="status" value="For Investigation" required > For Investigation 
					  
                </label> 
				<label class="checkbox-inline">
                      <input type="radio"  name="status" id="status" value="For Endorsement" required > For Endorsement 
					  
                </label> 
				</div>
				<div class="form-group">
				 <label class="checkbox-inline">
                         <input type="radio"  name="status" value="For comments and recommendations" required > For comments and recommendations
                    </label>    
				
			
			</div>	
			
			
		
			<div class="modal-footer">
		<input type="submit" name="new_transaction" value="SUBMIT TRANSACTION" class="btn btn-primary">
        </form>
		</div>
		</div>
		

		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->


