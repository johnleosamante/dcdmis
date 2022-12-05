  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Deployment History</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
	include("../vendor/jquery/function.php");
	    $_SESSION['per_id']=$_GET['id'];
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['id']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					
					echo '<b>';
					echo '<img src="'.$data['Picture'].'" width="200" height="170" align="right">';
					echo '<p>Employee ID: '.$_GET['id'].'</p>';
					echo '<p>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</p>';
					echo '<p>Current Station: '.$data['SchoolName'].'</p>';
					echo  '<p>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</p>';
					echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p ><br style="padding:10px;"/><hr />';
					echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;">#</th>
												<th width="20%">Date of Assignment</th>
												<th width="30%">Station</th>
												<th width="10%">Position</th>
												<th width="10%">Period Rendered</th>
											</tr>
																					
									</thead>
									<tbody>';
										
										$no=0;
										$myinfo=mysqli_query($con,"SELECT * FROM tbl_deployment_history INNER JOIN tbl_school ON tbl_deployment_history.station_assign = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_deployment_history.position_assign = tbl_job.Job_code WHERE tbl_deployment_history.Emp_ID='".$_GET['id']."'")or die ("Deployment Information error");
									while($row=mysqli_fetch_array($myinfo))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td>'.$row['Date_assignment'].'</td>
													<td>'.$row['SchoolName'].'</td>
													<td>'.$row['Job_description'].'</td>
													<td style="text-align:center;">'.$row['No_of_years'].'</td>
												</tr>';
										}
											

									
                               echo '</tbody>
                            </table>		';
					
					?>
		</div>