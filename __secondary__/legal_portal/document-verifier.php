

	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <?php
						date_default_timezone_set("Asia/Manila");
						$dateposted = date("Y-m-d H:i:s");
						if (isset($_POST['dts']))
							{
								$_SESSION['Transcode']=$_POST['dts'];
							}elseif (isset($_POST['Recieve']))
							{
							mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='On Process' WHERE TransCode='".$_SESSION['Transcode']."' LIMIT 1");	
							if(mysqli_affected_rows($con)==1)
								{
									mysqli_query($con,"UPDATE tbl_transactions_log SET Status='Done' WHERE Transaction_code='".$_SESSION['Transcode']."' AND Forwarded_to='".$_SESSION['station']."' LIMIT 1");	
							
									mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','-','On Process','".$_SESSION['Transcode']."','New')");
								
								?>
									<script type="text/javascript">
									$(document).ready(function(){						
										 $('#verifier').modal({
											show: 'true'
										}); 				
									});
									</script>
									
							 
									<?php   
									}else{
									?>
									<script type="text/javascript">
									$(document).ready(function(){						
										 $('#error').modal({
											show: 'true'
										}); 				
									});
									</script>
									
							 
									<?php   }
							}elseif (isset($_POST['Released']))
							{
								
									mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='".$_POST['status']."' WHERE TransCode='".$_SESSION['Transcode']."' LIMIT 1");	
																	
						
							if(mysqli_affected_rows($con)==1)
								{
									mysqli_query($con,"UPDATE tbl_transactions_log SET Status='Done' WHERE Transaction_code='".$_SESSION['Transcode']."' AND Status ='New'");
									mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','".$_POST['officeTo']."','".$_POST['status']."','".$_SESSION['Transcode']."','New')");
										
									
								?>
									<script type="text/javascript">
									$(document).ready(function(){						
										 $('#verifier').modal({
											show: 'true'
										}); 				
									});
									</script>
									
							 
									<?php   
									}else{
									?>
									<script type="text/javascript">
									$(document).ready(function(){						
										 $('#access').modal({
											show: 'true'
										}); 				
									});
									</script>
									
							 
									<?php   }
							}
						?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
						 $mystatus=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE  TransCode='".$_SESSION['Transcode']."' AND Trans_Stats <>'Done' LIMIT 1");
						 $row=mysqli_fetch_assoc($mystatus);
						 if ($row['Trans_Stats']=="Completed")
											{
												echo '<a href="print-report.php?id='.$row['TransCode'].'&From='.$row['Trans_from'].'" class="btn btn-success" target="_blank" style="float:right;">Click to Print</a>';
											
											}
										
							elseif ($row['Trans_Stats']=="For release")
											{
												echo '<a href="done.php?id='.$row['TransCode'].'&From='.$row['Trans_from'].'" class="btn btn-primary" style="float:right;" title="Complete Document">Click to Complete</a>';
											
											}
											elseif ($row['Trans_Stats']<>"On Process")
											{
											echo '<a href="view-recieve.php?id='.$row['TransCode'].'" data-toggle="modal" data-target="#Mylog" class="btn btn-primary" style="float:right;" title="Recieve Document">Click to receive</a>';
											}else{
											echo '<a href="confirm.php?id='.$row['TransCode'].'" data-toggle="modal" data-target="#Mylog" class="btn btn-primary" style="float:right;" title="Confirm Document">Click Next</a>';	
											}
						 echo '<label style="width:18%;">TRANSACTION CODE:</label><label>'.$row['TransCode'].'</label><br/>';	
						 echo '<label style="width:18%;">TITLE:</label><label>'.$row['Title'].'</label><br/>';	
						 echo '<label style="width:18%;">DATE/TIME CREATED:</label><label>'.$row['Date_time'].'</label><br/>';	
						 echo '<label style="width:18%;">FROM:</label><label>'.$row['Trans_from'].'</label><br/>';	
						 echo '<label style="width:18%;">CURRENT STATUS:</label><label>'.$row['Trans_Stats'].'</label><br/>';	
										
						 ?>
						 <hr/>
						 <h4>Transactions Logs</h4>
						 <table width="100%" class="table table-striped table-bordered table-hover" >
				<thead>
					<tr>
						<th rowspan="2" width="7%" style="text-align:center;">#</th>
						<th rowspan="2">Date / Time Received</th>
						<th rowspan="2">Received by</th>
						<th colspan="2" width="40%" style="text-align:center;"> Offices</th>
						<th rowspan="2" width="15%">Status</th>
					</tr>
				<tr>
					<th width="20%" style="text-align:center;">From</th>
					<th width="20%" style="text-align:center;">To</th>
				</tr>					
				</thead>
											
					<tbody>
						<?php
						
						$no=0;
						$data=mysqli_query($con,"SELECT * FROM tbl_transactions_log INNER JOIN tbl_employee ON tbl_transactions_log.Recieved_by = tbl_employee.Emp_ID WHERE tbl_transactions_log.Transaction_code='".$_SESSION['Transcode']."' ORDER BY tbl_transactions_log.Date_recieved Desc");
						 while($row=mysqli_fetch_array($data))
						 {
							 $no++;
							 echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$row['Date_recieved'].'</td>
										<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
										<td style="text-align:center;">'.$row['From_office'].'</td>
										<td style="text-align:center;">'.$row['Forwarded_to'].'</td>
										<td>'.$row['Trans_status'].'</td>
									</tr>';
						 }
						?>	
						
					</tbody>
	</table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           
						 
						 <div class="panel-body">
                            
                            <!-- Modal -->
                            <div class="modal fade" id="Mylog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
										
										
										
										
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        <!-- .panel-body -->