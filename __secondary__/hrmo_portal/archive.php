
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>List of Archive</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <ul class="nav nav-tabs">
                                <li class="active">
									<a href="#leave_apply" data-toggle="tab"> Retired</a>
                                </li>
                                <li>
									<a href="#myLeave" data-toggle="tab"> Resigned</a>
                                </li>
                                <li>
									<a href="#MyRequest" data-toggle="tab"> Transfered</a>
                                </li>
                                
                        </ul>
                            
							
							<!-- Tab panes -->
                            <div class="tab-content">
							 <div class="tab-pane fade in active" id="leave_apply">
								<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						            <h3>List of Retired</h3>
													 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body">
												<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
													<thead>
															  <tr>
																	<th width="5%">#</th>
																	<th width="15%">Last Name</th>
																	<th width="14%">First Name</th>
																	<th width="14%">Middle Name</th>
																	<th width="5%">Extension</th>
																	<th width="10%">Sex</th>
																	<th width="15%">Station</th>
																	<th width="15%">Position</th>
																	<th width="7%">Date Retired</th>
																</tr>
															</thead>
                                <tbody>
									<?php
									$no=0;
								    $retired=mysqli_query($con,"SELECT * FROM tbl_archive INNER JOIN tbl_employee ON tbl_archive.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID WHERE  tbl_employee.Emp_Status='Retired'");
									while($rerow=mysqli_fetch_array($retired))
									{
										$no++;
										echo '<tr>
													<td >'.$no.'</td>
													<td >'.$rerow['Emp_LName'].'</td>
													<td >'.$rerow['Emp_FName'].'</td>
													<td >'.$rerow['Emp_MName'].'</td>
													<td >'.$rerow['Emp_Extension'].'</td>
													<td >'.$rerow['Emp_Sex'].'</td>
													<td >'.$rerow['Abraviate'].'</td>
													<td >'.$rerow['Job_description'].'</td>
													<td >'.$rerow['Date_deactivate'].'</td>
													
												</tr>';
									}
									?>
                                </tbody>
                            </table>	
						
							
							
							
							
							
				       </div>
					</div>
                        <!-- /.panel-body -->
                       </div>
					   </div>
							
<!--Next Tab-->
						<div class="tab-pane fade" id="myLeave">
									<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						             <h3>List of Resigned</h3>
													 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body">
												<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
														<thead>
																<tr>
																	<th width="5%">#</th>
																	<th width="15%">Last Name</th>
																	<th width="14%">First Name</th>
																	<th width="14%">Middle Name</th>
																	<th width="5%">Extension</th>
																	<th width="10%">Sex</th>
																	<th width="15%">Station</th>
																	<th width="15%">Position</th>
																	<th width="7%">Date Resigned</th>
																</tr>
															</thead>
                                <tbody>
								<?php
									$no=0;
								    $resign=mysqli_query($con,"SELECT * FROM tbl_archive INNER JOIN tbl_employee ON tbl_archive.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID WHERE  tbl_employee.Emp_Status='Resigned'");
									while($rrow=mysqli_fetch_array($resign))
									{
										$no++;
										echo '<tr>
													<td >'.$no.'</td>
													<td >'.$rrow['Emp_LName'].'</td>
													<td >'.$rrow['Emp_FName'].'</td>
													<td >'.$rrow['Emp_MName'].'</td>
													<td >'.$rrow['Emp_Extension'].'</td>
													<td >'.$rrow['Emp_Sex'].'</td>
													<td >'.$rrow['Abraviate'].'</td>
													<td >'.$rrow['Job_description'].'</td>
													<td >'.$rrow['Date_deactivate'].'</td>
													
												</tr>';
									}
									?>
                                </tbody>
                            </table>		
							
													</div>
						
											</div>
                        <!-- /.panel-body -->
                       </div></div>
							
						<!--Next Tab-->	
							<div class="tab-pane fade" id="MyRequest">
								<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						            <h3>List of Transfered</h3>				 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body">
												<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
													 <thead>
																<tr>
																	<th width="5%">#</th>
																	<th width="15%">Last Name</th>
																	<th width="14%">First Name</th>
																	<th width="14%">Middle Name</th>
																	<th width="5%">Extension</th>
																	<th width="10%">Sex</th>
																	<th width="15%">Station</th>
																	<th width="15%">Position</th>
																	<th width="7%">Date Transfered</th>
																</tr>
															</thead>
																	

																<tbody>
																<?php
																	$no=0;
																	$trans=mysqli_query($con,"SELECT * FROM tbl_archive INNER JOIN tbl_employee ON tbl_archive.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID WHERE  tbl_employee.Emp_Status='Transfered'");
																	while($rowtra=mysqli_fetch_array($trans))
																	{
																		$no++;
																		echo '<tr>
																					<td >'.$no.'</td>
																					<td >'.$rowtra['Emp_LName'].'</td>
																					<td >'.$rowtra['Emp_FName'].'</td>
																					<td >'.$rowtra['Emp_MName'].'</td>
																					<td >'.$rowtra['Emp_Extension'].'</td>
																					<td >'.$rowtra['Emp_Sex'].'</td>
																					<td >'.$rowtra['Abraviate'].'</td>
																					<td >'.$rowtra['Job_description'].'</td>
																					<td >'.$rowtra['Date_deactivate'].'</td>
																					
																				</tr>';
																	}
																	?>
																	
																</tbody>
															   </table>		
							
													</div>
						
											</div>
                        <!-- /.panel-body -->
                       </div>
					   
							
							
							
                        </div>
                        </div><!--End-->
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            