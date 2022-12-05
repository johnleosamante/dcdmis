
            <div class="row">
			<div class="col-lg-4">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      
						<h4>SUPERVISOR CATEGORY</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>Position</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
							</tr>
						 </thead>
						  <tbody>
							  <?php
							   $total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job WHERE Job_Category='Supervisor' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female' AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													
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
                      
						<h4>PRINCIPAL CATEGORY</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>Position</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
							</tr>
						 </thead>
						  <tbody>
							  <?php
							   $total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job WHERE Job_Category='Principal' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female' AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													
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
                      
				  <h4>HEAD TEACHER CATEGORY</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>Position</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
							</tr>
						 </thead>
						  <tbody>
							  <?php
							   $total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job WHERE Job_Category='Head Teacher' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female' AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													
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
				
				
				
				<div class="col-lg-4">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      
						<h4>MASTER TEACHER CATEGORY</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>Position</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
							</tr>
						 </thead>
						  <tbody>
							  <?php
							   $total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job WHERE Job_Category='Master Teacher' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
									   $maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female' AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													
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
                      
				  <h4>TEACHER CATEGORY</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>Position</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
							</tr>
						 </thead>
						  <tbody>
							  <?php
							  $total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job WHERE Job_Category='Teacher' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													
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
				
				
				
				
				
				
				
				
				
				
            </div>
           
	