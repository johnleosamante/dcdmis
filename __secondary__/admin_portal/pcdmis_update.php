 <div class="row">
                 <div class="col-lg-4">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	<h4>PERSONNEL 201 FILE SUMMARY</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover">
						  <thead>
							<tr>
							
									<th width="10%">#</th>
									<th style="text-align:center;">DATE</th>
									<th style="text-align:center;">PERSONNEL NAME</th>
									<th style="text-align:center;">STATION</th>
						  </tr>
						  </thead>
						  <tbody>
						   <?php
                            $result=mysqli_query($con,"SELECT * FROM tbl_201_file INNER JOIN tbl_employee ON tbl_201_file.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_201_file.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID ORDER BY tbl_201_file.DateUpload Asc");	
							$no=0;
							while($row=mysqli_fetch_array($result))
							{
								$no++;
										echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$row['DateUpload'].'</td>
										<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
										<td>'.$row['SchoolName'].'</td>
																				
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
				 <div class="col-lg-4">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
						 	<h4>PERSONNEL SERVICE RECORD SUMMARY</h4>
                        </div>    
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							  <thead>
								 <tr>
									<th width="10%">#</th>
									<th style="text-align:center;">DATE</th>
									<th style="text-align:center;">PERSONNEL NAME</th>
									<th style="text-align:center;">STATION</th>
								</tr>
							 </thead>
						  <tbody>
							<?php
							//mb_strimwidth($rowhist['Date_time'],0,10)
							$no=0;
							  $history=mysqli_query($con,"SELECT * FROM tbl_sr_logs INNER JOIN tbl_employee ON tbl_sr_logs.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_sr_logs.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID ORDER BY tbl_sr_logs.DateUpload Asc");	
							  while ($rowhist=mysqli_fetch_array($history))
							  {
								  $no++;
										echo '<tr>
										<td style="text-align:center;">'.$no.'</td>
										<td>'.$rowhist['DateUpload'].'</td>
										<td>'.$rowhist['Emp_LName'].', '.$rowhist['Emp_FName'].'</td>
										<td>'.$rowhist['SchoolName'].'</td>
																				
									</tr>';
							  }
							  
							?>
						  </tbody>
						  </table>
						</div>
					</div>
				  </div>
				 <div class="col-lg-4">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
						 	<h4>HRMO UPDATES</h4>
                        </div>    
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						  <h3>201 Files updates</h3>
						  <?php
						  $ration=mysqli_query($con,"SELECT * FROM tbl_employee WHERE Emp_Status='Active'");
						  
						  echo '<label style="font-size:25px;">Total Ratio: '.mysqli_num_rows($result).' / '.number_format(mysqli_num_rows($ration),0).'</label>';
						  ?>
						    <h3>Service records updates</h3>
							<?php
							 $sr=mysqli_query($con,"SELECT * FROM tbl_sr_logs INNER JOIN tbl_employee ON tbl_sr_logs.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_sr_logs.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID");	
							  echo '<label style="font-size:25px;">Total Ratio: '.mysqli_num_rows($sr).' / '.number_format(mysqli_num_rows($ration),0).'</label>';
							?>
						</div>
					</div>
				  </div>
				
   </div>
               
