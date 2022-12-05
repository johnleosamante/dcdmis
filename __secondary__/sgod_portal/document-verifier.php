
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
									mysqli_query($con,"UPDATE tbl_transactions_log SET Status='Done' WHERE Transaction_code='".$_SESSION['Transcode']."' LIMIT 1");	
							
									mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','-','On Process','".$_SESSION['Transcode']."','New')");
							
								$Err = "Transaction Successfully updated";
								echo '<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
															
									});</script>';	
								echo '<div class="alert alert-success">'.$Err.'<script>{window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'";}</script></div>';
								$_SESSION['Transcode']="";
									}else{
									$Err = "Transaction has a problem!!";
									echo '<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
															
									});</script>';	
									echo '<div class="alert alert-success">'.$Err.'<script>{window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'";}</script></div>';
								}
							}elseif (isset($_POST['Released']))
							{
							mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='".$_POST['status']."' WHERE TransCode='".$_SESSION['Transcode']."' LIMIT 1");	
							if(mysqli_affected_rows($con)==1)
								{
									if ($_POST['status']=='Completed')
									{
									mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','".$_POST['officeTo']."','".$_POST['status']."','".$_SESSION['Transcode']."','Done')");
									}else{
									mysqli_query($con,"INSERT INTO tbl_transactions_log VALUES(NULL,'".$dateposted."','".$_SESSION['uid']."','".$_SESSION['station']."','".$_POST['officeTo']."','".$_POST['status']."','".$_SESSION['Transcode']."','New')");
										
									}
								$Err = "Transaction Successfully updated";
								echo '<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
															
									});</script>';	
								echo '<div class="alert alert-success">'.$Err.'<script>{window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'";}</script></div>';
								$_SESSION['Transcode']="";
									}else{
									$Err = "Transaction has a problem!!";
									echo '<script type="text/javascript">
									$(document).ready(function(){						
									$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
															
									});</script>';	
									echo '<div class="alert alert-success">'.$Err.'</div>';
								}
							}
						?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
									 $mystatus=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE  TransCode='".$_SESSION['Transcode']."' AND Trans_Stats <>'Done' LIMIT 1");
									 $row=mysqli_fetch_assoc($mystatus);
										if ($row['Trans_Stats']=="Completed")
											{
												echo '<a href="print-report.php?id='.urlencode(base64_encode($row['TransCode'])).'" class="btn btn-success" target="_blank" style="float:right;">Click to Print</a>';
											
											}
										elseif ($row['Trans_Stats']=="For release")
											{
												echo '<a href="done.php?id='.urlencode(base64_encode($row['TransCode'])).'" class="btn btn-success"  style="float:right;"></i>Click to Complete</a>';
											
											}
											elseif ($row['Trans_Stats']<>"On Process")
											{
											echo '<a href="view-recieve.php?id='.urlencode(base64_encode($row['TransCode'])).'" data-toggle="modal" data-target="#Mylog" class="btn btn-success"  style="float:right;"></i>Click to receive</a>';
											}else{
											echo '<a href="confirm.php?id='.urlencode(base64_encode($row['TransCode'])).'" data-toggle="modal" data-target="#Mylog" class="btn btn-success"  style="float:right;">Click Next</a>';	
											}
						echo'<h3>Transactions Summary</h3></div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">';
						
						 echo '<table width="100%">
								<tr><td style="width:18%;">TRANSACTION CODE:</td><td>'.$row['TransCode'].'</td></tr>
								<tr><td style="width:18%;">TITLE:</td><td>'.$row['Title'].'</td></tr>	
								<tr><td style="width:18%;">DATE/TIME CREATED:</td><td>'.$row['Date_time'].'</td></tr>	
								<tr><td style="width:18%;">FROM:</td><td>'.$row['Trans_from'].'</td></tr>	
								<tr><td style="width:18%;">CURRENT STATUS:</td><td>'.$row['Trans_Stats'].'</td></tr></table>';	
										
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
						$data=mysqli_query($con,"SELECT * FROM tbl_transactions_log INNER JOIN tbl_employee ON tbl_transactions_log.Recieved_by = tbl_employee.Emp_ID WHERE tbl_transactions_log.Transaction_code='".$_SESSION['Transcode']."'");
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