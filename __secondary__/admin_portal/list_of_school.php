<?php
if (isset($_POST['send']))
 {
	 mysqli_query($con,"INSERT INTO tbl_school VALUES ('".$_POST['school_id']."','".$_POST['school_name']."','".$_POST['school_address']."','".$_POST['principal']."','".$_POST['Category']."','".$_POST['District']."','0','".$_POST['abbreviate']."','".$_POST['schoolType']."','123131','')")or die ("School record Error entry");
if (mysqli_affected_rows($con)==1)
			{
				 ?>
					<script type="text/javascript">
					$(document).ready(function(){						
						 $('#access').modal({
							show: 'true'
						}); 				
					});
					</script>
					
			 
					<?php 
			}
 }
?>
	<style>
	th,td{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="print_data.php?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=bGlzdF9vZl9zY2hvb2w%3D"  class="btn btn-secondary" style="float:right;" target="_blank">Print Enrolment</a>
						 <a href="" data-toggle="modal" data-target="#mySchool" class="btn btn-primary" style="float:right;">Add School</a>
							
						 	<h4> School's Masterlist</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                             <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                   <tr>
                                       	<th style="width:3%;" rowspan="2">School ID</th>
										<th style="width:45%;" rowspan="2">School Name</th>
										<th style="width:25%;" rowspan="2">Teacher-incharge</th>
										<th style="width:15%;" rowspan="2">District</th>
										<th  style="width:6%;text-align:center;" colspan="3"># of Personel</th>
										<th rowspan="2" style="width:15%;" >Progress</th>
										<th style="width:15%;" rowspan="2"># of Enrolled </th>
										<th style="text-align:center;width:5%;" rowspan="2"></th>
                                    </tr>
									
										<tr style="background-color:#0012;">
											<th  style="width:2%;text-align:center;">M</th>
											<th  style="width:2%;text-align:center;">F</th>
											<th  style="width:2%;text-align:center;">T</th>
										</tr>
									
                                </thead>
                                <tbody>
								<?php
								
									$recstudent=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_employee.Emp_ID=tbl_school.Incharg_ID INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code ORDER BY tbl_school.SchoolName Asc")or die ("School Table not found!");
									$no=$m=$f=$t=0;
									while($r = mysqli_fetch_assoc($recstudent)) {
										//Gender 
										$male=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_station.Emp_ID=tbl_employee.Emp_ID WHERE tbl_employee.Emp_Sex ='Male' AND tbl_station.Emp_Station='".$r['SchoolID']."'");
										$m=mysqli_num_rows($male);
										$female=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_station.Emp_ID=tbl_employee.Emp_ID WHERE tbl_employee.Emp_Sex ='Female' AND tbl_station.Emp_Station='".$r['SchoolID']."'");
										$f=mysqli_num_rows($female);
										$t=$m+$f;
										$regdata=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.SchoolID='".$r['SchoolID']."' AND school_year='".$_SESSION['year']."'");
										print '<td>'.$r['SchoolID'].'</td>';
										print '<td>'.$r['SchoolName'].'</td>';
										print '<td>'.$r['Emp_LName'].', '.$r['Emp_FName'].'</td>';
										print '<td>'.$r['District_Name'].'</td>';
										print '<td style="text-align:center;">'.$m.'</td>';
										print '<td style="text-align:center;">'.$f.'</td>';
										print '<td style="text-align:center;">'.$t.'</td>';
										print '<td><div id="myProgress" style="background:green;text-align:center;">
												<div id="myBar" style="width:'.$r['Status'].'%;color:white;">'.$r['Status'].' %
												</div></div></td>
												<td style="text-align:center;">'.mysqli_num_rows($regdata).'</td>
											<td style="text-align:center;">
												<a href=./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode($r['SchoolID'])).'&v='.urlencode(base64_encode("view_school")).'" class="btn btn-primary"> View</a>
																																						
											</td>
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
             
                            <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							<div class="modal fade" id="mySchool" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
									 <div class="modal-header">
										
										  <h3 class="modal-title"><center>New School</center></h3>
										 
										</div>
										<form action="" Method="POST" enctype="multipart/form-data">	
										<div class="modal-body">
											<label>SCHOOL ID:</label>
											<input type="number" name="school_id" class="form-control" placeholder="SchoolID information"> 
											<label>SCHOOL NAME:</label>
											<input type="text" name="school_name" class="form-control" placeholder="School Name information"> 
											<label>SCHOOL ADDRESS:</label>
											<input type="text" name="school_address" class="form-control" placeholder="School Address information"> 
											<label>SCHOOL PRINCIPAL:</label>
											<select class="form-control" name="principal">
											<option value="">--Select--</option>
											<?php
											$prin=mysqli_query($con,"SELECT * FROM tbl_employee ORDER BY Emp_LName Asc")or die ("Error PRINCIPAL");
											while($row=mysqli_fetch_array($prin))
												{
												echo '<option value="'.$row['Emp_ID'].'">'.$row['Emp_LName'].', '.$row['Emp_FName'].'</option>';
												}
											?>
											</select>
											
											<label>SCHOOL CATEGORY:</label>
											<select class="form-control" name="Category">
											<option value="">--Select--</option>
											<option value="Elementary">Elementary</option>
											<option value="Secondary">Secondary</option>
											
											</select>
											<label>SCHOOL DISTRICT:</label>
											<select class="form-control" name="District">
											<option value="">--Select--</option>
											<?php
											$prin=mysqli_query($con,"SELECT * FROM tbl_district WHERE District_code <>'D-115'")or die ("Error PRINCIPAL");
											while($row=mysqli_fetch_array($prin))
												{
												echo '<option value="'.$row['District_code'].'">'.$row['District_Name'].'</option>';
												}
											?>
											</select>
											<label>SCHOOL ABBREVIATION:</label>
											<input type="text" name="abbreviate"  class="form-control">
											<label>SCHOOL TYPE:</label>
											<select class="form-control" name="schoolType">
											<option value="">--Select--</option>
											<option value="Elementary">Elementary</option>
											<option value="Integrated">Integrated</option>
											<option value="Junior">Junior</option>
											<option value="Senior">Senior</option>
											
											</select>
										</div>
									<div class="modal-footer">
										<input type="submit" name="send" value="SAVE" class="btn btn-primary">
										  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									</div>
									</form>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        <!-- .panel-body -->