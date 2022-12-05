	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						<h4>Transactions History Archive</h4>
							
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
										$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.Trans_from<>'".$_SESSION['station']."' ORDER BY TransCode Desc");
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
               
