<style>
th{
	text-align:center;
}
</style>
            <div class="row">
			
                <div class="col-lg-6">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      
				  <h4>ELEMETARY LEVEL</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>School Year</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
								<th></th>
							</tr>
							
						 </thead>
						  <tbody>
							  <?php
							  $total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_school_year");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$malereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_school.School_Category ='Elementary'");
										$femalereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_school.School_Category ='Elementary'");
										$total=mysqli_num_rows($malereg)+mysqli_num_rows($femalereg);
										echo '<tr>
													<td>'.$rowelem['SchoolYear'].'</td>
													<td>'.number_format(mysqli_num_rows($malereg),0).'</td>
													<td>'.number_format(mysqli_num_rows($femalereg),0).'</td>
													<td>'.number_format($total,0).'</td>
													<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Cat='.urlencode(base64_encode("Elementary")).'&v='.urlencode(base64_encode("school_report")).'">VIEW</a></td>
													
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
				
				<div class="col-lg-6">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      
				  <h4>JUNIOR HIGH SCHOOL LEVEL</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>School Year</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
								<th></th>
							</tr>
						 </thead>
						  <tbody>
							  <?php
									$total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_school_year");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$malereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_school.School_Category ='Secondary' AND tbl_registration.Grade <='10'");
										$femalereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_school.School_Category ='Secondary' AND tbl_registration.Grade <='10'");
										$total=mysqli_num_rows($malereg)+mysqli_num_rows($femalereg);
										echo '<tr>
													<td>'.$rowelem['SchoolYear'].'</td>
													<td>'.number_format(mysqli_num_rows($malereg),0).'</td>
													<td>'.number_format(mysqli_num_rows($femalereg),0).'</td>
													<td>'.number_format($total,0).'</td>
													<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Cat='.urlencode(base64_encode("Secondary")).'&v='.urlencode(base64_encode("school_report")).'">VIEW</a></td>
													
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
				
				<div class="col-lg-6">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      
				  <h4>SENIOR HIGH SCHOOL LEVEL</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th>School Year</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
								<th></th>
							</tr>
						 </thead>
						  <tbody>
						  <?php
							  $total=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_school_year");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$malereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_school.School_Category ='Secondary' AND tbl_registration.Grade >='11' AND  tbl_registration.Grade <='12'");
										$femalereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_school.School_Category ='Secondary' AND tbl_registration.Grade >='11' AND  tbl_registration.Grade <='12'");
										$total=mysqli_num_rows($malereg)+mysqli_num_rows($femalereg);
										echo '<tr>
													<td>'.$rowelem['SchoolYear'].'</td>
													<td>'.number_format(mysqli_num_rows($malereg),0).'</td>
													<td>'.number_format(mysqli_num_rows($femalereg),0).'</td>
													<td>'.number_format($total,0).'</td>
													<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Cat='.urlencode(base64_encode("Secondary")).'&v='.urlencode(base64_encode("school_report")).'">VIEW</a></td>
													
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
				<div class="col-lg-12">
				</div>
                <!-- /.col-lg-12 -->
				<?php
				
				$district=mysqli_query($con,"SELECT * FROM tbl_district WHERE District_Name<>'PAGADIAN CITY DIVISION'");
				while ($rowdist=mysqli_fetch_array($district))
				{
				 echo '<div class="col-lg-6">
                    <div class="panel panel-default">
					 <div class="panel-heading">
                      
				  <h4>'.$rowdist['District_Name'].'</h4>
				 
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						 <table width="100%" class="table table-striped table-bordered table-hover" >
						 <thead>
							<tr>
								<th rowspan="2">School Name</th>
								<th colspan="3">Enrollment Quick Count</th>
								<th colspan="3">Personnel Quick Count</th>
															
							</tr>
							<tr>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
								<th>Male</th>
								<th>Female</th>
								<th>Total</th>
							</tr>
						 </thead>
						  <tbody>';
						  $male=$female=$total=0;
						 $districtdata=mysqli_query($con,"SELECT * FROM tbl_school WHERE District_code='".$rowdist['District_code']."'");	
						 while($rowdistdata=mysqli_fetch_array($districtdata))
						 {
							 //Call Male
							 $myregistration=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn =tbl_student.lrn WHERE tbl_student.Gender ='MALE' AND tbl_registration.SchoolID='".$rowdistdata['SchoolID']."'");
							 $male=mysqli_num_rows($myregistration);
							  //Call FEMale
							 $myregistration=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn =tbl_student.lrn WHERE tbl_student.Gender ='FEMALE' AND tbl_registration.SchoolID='".$rowdistdata['SchoolID']."'");
							 $female=mysqli_num_rows($myregistration);
							 $total=$male+$female;
							 echo '<tr>
									<td>'.$rowdistdata['SchoolName'].'</td>
									<td style="text-align:center;">'.number_format($male,0).'</td>
									<td style="text-align:center;">'.number_format($female,0).'</td>
									<td style="text-align:center;">'.number_format($total,0).'</td>
									<td style="text-align:center;">'.number_format($male,0).'</td>
									<td style="text-align:center;">'.number_format($female,0).'</td>
									<td style="text-align:center;">'.number_format($total,0).'</td>
									</tr>';
						 }
						echo '</tbody>
						  </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>';
				}
				?>
                <!-- /.col-lg-12 -->
				
            </div>
           
	