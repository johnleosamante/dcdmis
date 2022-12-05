 <div class="row">
                 <div class="col-lg-6">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	<h4>Transactions History</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover">
						  <thead>
							<tr>
							<th style="text-align:center;">#</th>
							<th>SECTION</th>
							<th style="text-align:center;">ON PROCESS</th>
							<th style="text-align:center;">FOR APPROVAL</th>
							<th style="text-align:center;">FOR SIGNATURE</th>
						  </tr>
						  </thead>
						  <tbody>
						   <?php
                            $result=mysqli_query($con,"SELECT * FROM tbl_deparment ORDER BY Offices Asc");	
							$no=0;
							while($row=mysqli_fetch_array($result))
							{
								$onprocess=mysqli_query($con,"SELECT * FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode=tbl_transactions_log.Transaction_code WHERE tbl_transactions.Trans_Stats='On Process' AND tbl_transactions_log.From_office='".$row['Offices']."' AND tbl_transactions_log.Status = 'New' GROUP BY tbl_transactions_log.Transaction_code");
								$forapproval=mysqli_query($con,"SELECT * FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode=tbl_transactions_log.Transaction_code WHERE tbl_transactions.Trans_Stats='For Approval' AND tbl_transactions_log.From_office='".$row['Offices']."' AND tbl_transactions_log.Status = 'New' GROUP BY tbl_transactions_log.Transaction_code");
								$forsignature=mysqli_query($con,"SELECT * FROM tbl_transactions INNER JOIN tbl_transactions_log ON tbl_transactions.TransCode=tbl_transactions_log.Transaction_code WHERE tbl_transactions.Trans_Stats='For signature' AND tbl_transactions_log.From_office='".$row['Offices']."' AND tbl_transactions_log.Status = 'New' GROUP BY tbl_transactions_log.Transaction_code");
								$no++;
										echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$row['Offices'].'</td>
										<td style="text-align:center;">'.number_format(mysqli_num_rows($onprocess),0).'</td>
										<td style="text-align:center;">'.number_format(mysqli_num_rows($forapproval),0).'</td>
										<td style="text-align:center;">'.number_format(mysqli_num_rows($forsignature),0).'</td>
										
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
				 <div class="col-lg-6">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="downloadexcel.php" style="float:right;" class="btn btn-primary">Download Excel</a>
						 	<h4>Transactions History by Date</h4>
                        </div>    
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							  <thead>
								 <tr>
									<th width="30%">DATE</th>
									<th style="text-align:center;">STATUS</th>
									<th style="text-align:center;">STATION</th>
								</tr>
							 </thead>
						  <tbody>
							<?php
							//mb_strimwidth($rowhist['Date_time'],0,10)
							$no=0;
							  $history=mysqli_query($con,"SELECT * FROM tbl_transactions ORDER BY Date_time Desc");
							  while ($rowhist=mysqli_fetch_array($history))
							  {
								  $no++;
								  echo '<tr>
											<td>'.$rowhist['Date_time'].'</td>
											<td style="text-align:center;">'.$rowhist['Trans_Stats'].'</td>
											<td style="text-align:center;">'.$rowhist['Trans_from'].'</td>
											
										</tr>';
							  }
							  
							?>
						  </tbody>
						  </table>
						</div>
					</div>
				  </div>
				
				
   </div>
               
