

	<style>
		th{
			text-align:center;
		}
	</style>                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Leaved Personnel Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                               <thead>
                                    <tr>
                                        <th width="5%" rowspan="2">#</th>
                                        <th width="10%" rowspan="2">Name</th>
                                        <th width="10%" rowspan="2">Date of Application</th>
                                        <th width="10%" rowspan="2">Type of Leave Credits</th>
                                        <th width="10%" rowspan="2">With / With out Pay</th>
                                        <th width="5%" rowspan="2">Number of Days</th>
                                        <th width="20%" rowspan="2">Reason for Leave of Absent</th>
                                        <th width="20%" colspan="2">Inclusive Date</th>
                                        <th width="10%" rowspan="2">Status</th>
										
                                    </tr>
									<tr>
										<th>From</th>
										<th>To</th>
									</tr>	
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM  tbl_leave_applied INNER JOIN tbl_employee ON tbl_leave_applied.Emp_ID =tbl_employee.Emp_ID INNER JOIN tbl_leave ON tbl_leave_applied.Type_of_Leave=tbl_leave.LeaveCode WHERE tbl_leave_applied.Status<>'Rendered'")or die ("Leave Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
										if ($row['Date_To']==date('Y-m-d'))
										{
											mysqli_query($con,"UPDATE tbl_leave_applied SET tbl_leave_applied.Status='Rendered' WHERE tbl_leave_applied.Emp_ID='".$row['Emp_ID']."' AND tbl_leave_applied.No = '".$row['No']."' LIMIT 1");
										}
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
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
										
									?>
                                </tbody>
                            </table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
         