
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						  <a href="" class="btn btn-primary" style="float:right;">Print Masterlist</a>
							<h4>Personnel request for transfer Masterlist</h4> 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
								<tr>
										<th>Date of Original Appointment</th>
										<th>Request by</th>
										<th>Previous School </th>
										<th>No. of Years </th>
										<th>Current Station </th>
										<th>No. of Years </th>
										<th>Transfer To</th>
										<th>Reason to Transfer</th>
										<th>Status</th>
										<th></th>
										
									</tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myrequest=mysqli_query($con,"SELECT * FROM tbl_transfer_data INNER JOIN tbl_employee ON tbl_transfer_data.Trans_Emp_ID=tbl_employee.Emp_ID")or die("Error transfer data");
									while($rtransfer=mysqli_fetch_array($myrequest))
									{
									
									echo '<tr>
										<td>'.$rtransfer['Date_of_original_appointment'].'</td>
										<td>'.$rtransfer['Emp_LName'].', '.$rtransfer['Emp_FName'].'</td>
										<td>'.$rtransfer['PrevousStation'].'</td>
										<td>'.$rtransfer['YearRender'].'</td>
										<td>'.$rtransfer['Trans_From'].'</td>
										<td>'.$rtransfer['No_of_year'].'</td>
										<td>'.$rtransfer['Trans_TO'].'</td>
										<td>'.$rtransfer['Trans_Reason'].'</td>
										<td>'.$rtransfer['Trans_Status'].'</td>
										<td style="text-align:center;">						
										<a href=""><i class="fa fa-desktop fa"></i></a>																													
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
              
