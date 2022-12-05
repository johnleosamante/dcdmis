
                 		
						<ul class="nav nav-tabs">
                                <li class="active">
									<a href="#leave_apply" data-toggle="tab">List of Leave applied</a>
                                </li>
                                <li>
									<a href="#myLeave" data-toggle="tab">List of Leave</a>
                                </li>
                                <li>
									<a href="#MyRequest" data-toggle="tab">Request for Leave</a>
                                </li>
                                 <li>
									<a href="#MyTransfer" data-toggle="tab">Request for Transfer</a>
                                </li>
                        </ul>
						
						 <!-- Tab panes -->
                            <div class="tab-content">
							
							 <div class="tab-pane fade in active" id="leave_apply">
								<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						            <h4>List of Leave Applied</h4>
													 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body" style="overflow-x:auto;">
												<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%" rowspan="2">#</th>
                                        <th width="10%" rowspan="2">Date of Application</th>
                                        <th width="20%" rowspan="2">Type of Leave Credits</th>
                                        <th width="10%" rowspan="2">With / With out Pay</th>
                                        <th width="10%" rowspan="2">Number of Days</th>
                                        <th width="20%" rowspan="2">Reason for Leave of Absent</th>
                                        <th width="20%" colspan="2">Inclusive Date</th>
										<th width="5%" rowspan="2">Status</th>
                                    </tr>
									<tr>
										<th>From</th>
										<th>To</th>
									</tr>	
                                </thead>
                                <tbody>
								<?php
								$no=$sum=$sum1=$sum2=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_leave_applied INNER JOIN tbl_leave ON tbl_leave_applied.Type_of_Leave=tbl_leave.LeaveCode WHERE tbl_leave_applied.Emp_ID='".$_SESSION['EmpID']."'")or die ("Credit Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										$sum=$sum+$row['Number_of_days'];
										if ($row['Leave_Status']=='With')
										{
										$sum2=$sum2+1;	
										}else{
											$sum1=$sum1+1;
										}
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Date_approved'].'</td>
											<td>'.$row['LeaveDescription'].'</td>
											<td>'.$row['Leave_Status'].'</td>
											<td style="text-align:center;">'.$row['Number_of_days'].'</td>
											<td>'.$row['Reason_for_leave_of_absent'].'</td>
											<td>'.$row['Date_From'].'</td>
											<td>'.$row['Date_To'].'</td>
											<td>'.$row['Status'].'</td>
											</tr>';
                                    
									}	
										echo '<h3>Total Leave Credits Applied: '.$sum.'</h3>';
										echo '<h3>Total Without Pay: '.$sum1.'</h3>';
										echo '<h3>Total With Pay: '.$sum2.'</h3>';
									?>
                                </tbody>
                            </table>		
				
							
									</div>
						
								</div>
                        <!-- /.panel-body -->
                       </div>
					 </div>
							
								 <div class="tab-pane fade" id="myLeave">
									<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						             <h4>List of Leave</h4>
													 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body" style="overflow-x:auto;">
												<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="10%">Date</th>
                                        <th width="20%">Legal Basis / Memo / Special Order</th>
                                        <th width="15%">Type of Leave Credits</th>
                                        <th width="15%">Number of Days</th>
                                        <th width="30%">Type of Service Rendered</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=$sum=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_leave_credits INNER JOIN tbl_leave ON tbl_leave_credits.Type_of_leave_credit=tbl_leave.LeaveCode WHERE tbl_leave_credits.Emp_ID='".$_SESSION['EmpID']."'")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										$sum=$sum+$row['Number_of_days'];
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Leave_date'].'</td>
											<td>'.$row['Legal_basis'].'</td>
											<td>'.$row['LeaveDescription'].'</td>
											<td style="text-align:center;">'.$row['Number_of_days'].'</td>
											<td>'.$row['Type_of_service_rendered'].'</td>
											</tr>';
                                    
									}	
										echo '<h3>Total Leave Credits: '.$sum.'</h3>';
									?>
                                </tbody>
                            </table>		
							
													</div>
						
											</div>
                        <!-- /.panel-body -->
                       </div>
					   
									
								  </div>
							  <div class="tab-pane fade" id="MyRequest">
								<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						             <a href="#myRetiree" data-toggle="modal"  class="btn btn-primary">New Request</a>
													 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body" style="overflow-x:auto;">
												<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
													<thead>
														<tr>
															<th rowspan="2">#</th>
															<th rowspan="2">Request by</th>
															<th rowspan="2">Request for</th>
															<th rowspan="2">Date Apply</th>
															<th rowspan="2"># of Days</th>
															<th colspan="2">Inclusive Date</th>
															<th rowspan="2">Status</th>
											
															</tr>
															<tr>
																<th>From</th>
																<th>To</th>
																
															</tr>
										
																</thead>
																<tbody>
																<?php
																		$no=0;
																			$request_data=mysqli_Query($con,"SELECT * FROM tbl_request INNER JOIN tbl_employee ON tbl_request.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_leave ON tbl_request.Request_for=tbl_leave.LeaveCode WHERE tbl_request.Emp_ID='".$_SESSION['EmpID']."'")or die("error data request");
																			while($row_request=mysqli_fetch_array($request_data))
																			{
																				$no=$no+1;
																				echo '<tr>
																			<td>'.$no.'</td>
																			<td>'.$row_request['Emp_LName'].', '.$row_request['Emp_FName'].'</td>
																			<td>'.$row_request['LeaveDescription'].'</td>
																			<td>'.$row_request['Date_apply'].'</td>
																			<td style="text-align:center">'.$row_request['Number_of_days'].'</td>
																			<td>'.$row_request['Request_From'].'</td>
																			<td>'.$row_request['Request_To'].'</td>
																			<td>'.$row_request['Request_status'].'</td>
																			
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
                    <!-- /.panel -->
					
					
					<div class="tab-pane fade" id="MyTransfer">
								<div class="col-lg-12">
						          <div class="panel panel-default">
                                    <div class="panel-heading">
						            	  <h4>Request for transfer</h4>										 
                                     </div>
											<!-- /.panel-heading -->
											<div class="panel-body" style="overflow-x:auto;">
											<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
													<thead>
														<tr>
															<th >#</th>
															<th >Station To</th>
															<th >Reason for Transfer</th>
															<th >Status</th>
											
															</tr>
																							
																</thead>
															<tbody>
															<tr>
															<?php
															$no=0;
															$rdata=mysqli_Query($con,"SELECT * FROM tbl_transfer_data WHERE tbl_transfer_data.Trans_Emp_ID='".$_SESSION['EmpID']."'");
															while ($rowdata=mysqli_fetch_array($rdata))
																{
																	$no++;
																	echo '<td>'.$no.'</td>';
																	echo '<td>'.$rowdata['Trans_TO'].'</td>';
																	echo '<td>'.$rowdata['Trans_Reason'].'</td>';
																	echo '<td>'.$rowdata['Trans_Status'].'</td>';
																}
															?>
															</tr><tr>
															<form action="save_transfer.php" Method="POST">
															<th colspan="2">
																<?php
																 $result=mysqli_query($con,"SELECT * FROM tbl_school");
																 echo '<select name="trans_to" class="form-control" required>
																		<option value="">--Select--</option>';
																 while($row=mysqli_fetch_array($result))
																	{
																	 echo '<option value="'.$row['SchoolName'].'">'.$row['SchoolName'].'</option>';
																	}
																 echo '</select>';
																?>
															</th>
															<th colspan="2"><input type="text" name="reason" placeholder="Reason to Transfer" class="form-control" required></th>
															<td><input type="submit" name="submit" value="Submit" class="btn btn-secondary"> </td>
															</tr>
															</form>
														</tbody>
												  </table>
											
											</div>
						
							</div>
                        <!-- /.panel-body -->
                       </div>
											
                </div>
                </div>
                
              
            

<!-- Modal -->
  <div class="modal fade" id="myRetiree" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="loginbox">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>New Request Entry </h4>
        </div>
        <div class="modal-body">
            <div class="row">
				<form action="save_request.php" Method="POST">
                <div class="panel panel-default">
                      <div class="panel-body" >
                           
							<label>Date of Application:</label>
							<input type="date" name="date_apply"  class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
							<label>Request for:</label>
							<select name="request_for" class="form-control" required>
								<option value="">--Select--</option>
								<?php
								$request=mysqli_query($con,"SELECT * FROM tbl_leave");
								while($row=mysqli_fetch_array($request))
									{
									echo '<option value="'.$row['LeaveCode'].'">'.$row['LeaveDescription'].'</option>';
									}
								?>
							</select>
							<label>Number of Days:</label>
							<input type="number" name="No_of_day" placeholder="Number of days" class="form-control" required>					
							<label>From:</label>
							<input type="date" name="req_from" placeholder="From " class="form-control" required>					
							<label>To:</label>
							<input type="date" name="req_to" placeholder="To " class="form-control" required>					
							
							</div>
							
                </div>
				<div class="panel-footer">
				<input type="submit" class="btn btn-primary" name="save" value="SUBMIT">
				</form>
				</div>
            </div>
        </div>
      </div>
    </div>
  </div>
  
     
           