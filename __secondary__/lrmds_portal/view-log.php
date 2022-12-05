	<style>
	th{
		text-transform:uppercase;
	}
	</style>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
									 $mystatus=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE  TransCode='".$_GET['id']."' AND Trans_Stats <>'Done' LIMIT 1");
									 $row=mysqli_fetch_assoc($mystatus);
										
										
						echo'<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transaction")).'" class="btn btn-success" style="float:right;">Back</a>
                       <!-- /.panel-heading -->
                        <div class="panel-body">
						
						      <table width="100%">
								<tr><td style="width:18%;">TRANSACTION CODE:</td><td>'.$row['TransCode'].'</td></tr>
								<tr><td style="width:18%;">TITLE:</td><td>'.$row['Title'].'</td></tr>	
								<tr><td style="width:18%;">DATE/TIME CREATED:</td><td>'.$row['Date_time'].'</td></tr>	
								<tr><td style="width:18%;">FROM:</td><td>'.$row['Trans_from'].'</td></tr>	
								<tr><td style="width:18%;">CURRENT STATUS:</td><td>'.$row['Trans_Stats'].'</td></tr></table>';	

						if (isset($_POST['uptrans']))
						{
							mysqli_query($con,"UPDATE tbl_transactions SET Trans_Stats='".$_POST['status']."' WHERE TransCode='".$_SESSION['TransCode']."' LIMIT 1");
							mysqli_query($con,"UPDATE tbl_transactions_log SET Trans_status='".$_POST['status']."',Forwarded_to='".$_POST['officeTo']."' WHERE No='".$_SESSION['No']."' AND Transaction_code='".$_SESSION['TransCode']."' LIMIT 1");
					
							if (mysqli_affected_rows($con)==1)
								{
									
								$Err = "Transaction Successfully Saved";
										echo '<script type="text/javascript">
											$(document).ready(function(){						
											$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
											
											});</script>
											';	
									echo '<div class="alert alert-success">'.$Err.'</div>';
								}
						}
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
						$data=mysqli_query($con,"SELECT * FROM tbl_transactions_log INNER JOIN tbl_employee ON tbl_transactions_log.Recieved_by = tbl_employee.Emp_ID WHERE tbl_transactions_log.Transaction_code='".$_GET['id']."' ORDER BY Date_recieved Desc");
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
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="Myupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						