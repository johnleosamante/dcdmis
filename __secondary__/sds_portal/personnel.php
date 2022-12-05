
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
							Personnel Masterlist 
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
                                        <th width="15%">Contact #</th>
					 <th width="15%">Email Add</th>
                                        <th width="15%">Position</th>
                                        <th width="5%"></th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status='Active' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr >
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Emp_LName'].'</td>
											<td>'.$row['Emp_FName'].'</td>
											<td>'.$row['Emp_MName'].'</td>
											<td style="text-align:center;">'.$row['Emp_Extension'].'</td>
											<td style="text-align:center;">'.$row['Emp_Sex'].'</td>
											<td>'.$row['Abraviate'].'</td>
											<td>'.$row['Emp_Cell_No'].'</td>
										      <td>'.$row['Emp_Email'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td>
													<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("service_rcord")).'" title="Service Record" class="btn btn-warning" style="padding:4px;margin:4px;"> <i class="fa   fa-folder fa-fw"></i></a>
													<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("profile")).'" title="Personal Data Sheet" class="btn btn-primary" style="padding:4px;margin:4px;"> <i class="fa   fa-user fa-fw"></i></a>
														
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
              
