  <div class="modal-header">
          
          <h3 class="modal-title"><center>Deployment History</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
include("../../pcdmis/vendor/jquery/function.php");
	   
					 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['id']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					
					echo '<b>';
					echo '<img src="../../../pcdmis/images/'.$data['Picture'].'" width="200" height="170" align="right">';
					echo '<p>Employee ID: '.$_GET['id'].'</p>';
					echo '<p>Employee Name: '.$data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName'].'</p>';
					echo '<p>Current Station: '.$data['SchoolName'].'</p>';
					echo  '<p>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</p>';
					echo  '<p>Contact No.: '.$data['Emp_Cell_No'].'</p ><br style="padding:10px;"/><hr />';
					echo ' <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="20%" colspan="2">SERVICE RECORD</th>
                                        <th width="30%" colspan="3">RECORDS OF APPOINTMENT</th>
                                        <th width="30%" colspan="2">OFFICE ENTITY / DIV</th>
                                        <th width="10%" rowspan="2">V/L ABSENCES W/O PAY</th>
                                        <th width="10%" rowspan="2">SEPARATION</th>
                                    </tr>
									<tr>
										<th>FROM</th>
										<th>TO</th>
										<th>DESIGNATION</th>
										<th>STATUS</th>
										<th>SALARY</th>
										<th>STN / PLACE OF ASSIGNMENT</th>
										<th>BRANCH</th>
										
                                </thead>
                                <tbody>';
										
										$result=mysqli_query($con,"SELECT * FROM tbl_service_records  WHERE tbl_service_records.Emp_ID='".$_GET['id']."'");
									while($row=mysqli_fetch_array($result))
										{
										
                                      echo '<tr>
											<td>'.$row['date_from'].'</td>
											<td>'.$row['date_to'].'</td>
											<td>'.$row['position'].'</td>
											<td>'.$row['work_status'].'</td>
											<td>'.number_format($row['salary'],2).'</td>
											<td>'.$row['station'].'</td>
											<td>'.$row['branch'].'</td>
											<td>'.$row['pay_status'].'</td>
											<td>'.$row['separation'].'</td>';
										}
									
                               echo '</tbody>
                            </table>		';
					
					?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		</div>