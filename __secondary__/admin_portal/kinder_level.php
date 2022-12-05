                 <h2></h2>
				 <div class="col-lg-12">
                    <div class="panel panel-default">
					 <div class="panel-heading">
					 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=bGlzdF9vZl9hcHBsaWNhbnQ%3D" class="btn btn-secondary" style="float:right;padding:4px;margin:4px;">Back</a>
                     						
				  <h2>List of Kinder applicants</h2>
				  
					   
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<div class="col-lg-12">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="10%">FAMILY NAME</th>											
												<th width="10%">GIVEN NAME</th>
												<th width="10%">MIDDLE NAME</th>
												<th width="10%">SEX</th>
												<th width="10%">CONTACT #</th>
												<th>ADDRESS</th>
												<th>STATUS</th>
												<th width="5%"></th>
											</tr>
																				
									</thead>
									<tbody>
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='KINDER' ORDER BY Last_Name Asc");
									while($row=mysqli_fetch_array($result))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$row['Last_Name'].'</td>
												<td>'.$row['First_Name'].'</td>
												<td>'.$row['Middle_Name'].'</td>
												<td>'.$row['Gender'].'</td>
												<td>'.$row['Contact_No'].'</td>
												<td>'.$row['Home_Address'].'</td>
												<td>'.$row['Status'].'</td>
												<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&account='.urlencode(base64_encode($row['Appl_No'])).'&Category='.urlencode(base64_encode("KINDER")).'&v='.urlencode(base64_encode("individual_rating")).'" title="View Applicant Profile"><i class="fa fa-desktop fa-fw"></i></a></td>
												 </tr>';
									}
									?>
								
									</tbody>
									</table>
                            
                        </div>
						
                        </div>
						
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
             
			  
		