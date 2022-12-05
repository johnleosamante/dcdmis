
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 
						 	<?php
							echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_school")).'" class="btn btn-secondary" style="float:right;" > Back</a>';
							  $record=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID ='".$_GET['c']."'  ORDER BY SchoolName Asc") or die ("Profile School Error");
							  $row=mysqli_fetch_assoc($record);
							  echo '<h3 class="media-heading" style="padding:4px;margin:4px;"><i class="fa  fa-map-marker  fa-fw"></i>'.$row['SchoolName'].'- School ID:'.$_GET['c'].'</h3> <p> 
									  <small class="text-muted" style="padding:4px;margin:4px;">'.$row['Address'].' </small>
									</p>';
							 $_SESSION['EmpID']=$row['Incharg_ID'];
							
							  ?>
								<table style="padding:4px;margin:10px;">
						<?php
							$repre=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_SESSION['EmpID']."' AND tbl_employee.Emp_Status ='Active'") or die("Table not found!!!");
							$data=mysqli_fetch_assoc($repre);
							
							echo '<img src="'.$data['Picture'].'" width="150" height="150" align="left" style="padding:4px;" id="pic">
							<tr style="text-transform:uppercase;"><td>Employee ID #:</td><td style="color:blue;padding:4px;margin:4px;">'.$_SESSION['EmpID'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Name: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_LName'].', '.$data['Emp_FName'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Sex: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Sex'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Position: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Job_description'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Contact No.: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Cell_No'].'</font></td></tr>';
					
						?>
								</table> 
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
										<th>Empyee ID</th>
										<th>Employee Name</th>
										<th>Gender</th>
										<th>Home Address</th>
										<th>Position</th>
										<th></th>
										
									</tr>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$recstudent=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_station.Emp_ID =tbl_employee.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_school.SchoolID='".$_GET['c']."' AND tbl_employee.Emp_Status ='Active' ORDER BY tbl_employee.Emp_LName Asc");
								$no=0;
									while($row=mysqli_fetch_array($recstudent))
										{
										$no+=1;
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td><td>'.$row['Emp_ID'].'</a></td>
												<td style="text-transform:uppercase;">'.utf8_encode($row['Emp_LName'].', '.$row['Emp_FName']).'</td>
												<td style="text-transform:uppercase;">'.$row['Emp_Sex'].'</td>
												<td style="text-transform:uppercase;">'.$row['Emp_Address'].'</td>
												<td style="text-transform:uppercase;">'.$row['Job_description'].'</td>
												<td>
													<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("myprofile")).'" title="Service Record"> PDS</a>
													<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("service_rcord")).'" title="Service Record"> S.R</a>
															
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
            
