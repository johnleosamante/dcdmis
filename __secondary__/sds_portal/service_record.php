
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
						 $emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['c']."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					 $_SESSION['EmpID']=$_GET['c'];
					 echo '<img src="../../../pcdmis/images/'.$data['Picture'].'" width="200" height="200"   style="padding:4px;margin:4px;border-radius:10px;" align="right">';
					 echo '<label>Employee ID: '.$_GET['c'].'</label><br/>';
					 echo '<label>Employee Name: '.utf8_encode($data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName']).'</label><br/>';
					 echo '<label>Station: '.$data['SchoolName'].'</label><br/>';
					 echo '<label>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</label>';
					 
		?>
					</div>
		<table width="100%" class="table table-striped table-bordered table-hover">
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
                                <tbody>
								<?php
								$result=mysqli_query($con,"SELECT * FROM tbl_service_records  WHERE tbl_service_records.Emp_ID='".$_GET['c']."'");
									while($row=mysqli_fetch_array($result))
										{
										
                                      echo '<tr class="gradeA">
											<td>'.$row['date_from'].'</td>
											<td>'.$row['date_to'].'</td>
											<td>'.$row['position'].'</td>
											<td>'.$row['work_status'].'</td>
											<td>'.$row['salary'].'</td>
											<td>'.$row['station'].'</td>
											<td>'.$row['branch'].'</td>
											<td>'.$row['pay_status'].'</td>
											<td>'.$row['separation'].'</td>';
											
											echo '</tr>';
                                    
									}	
									
										
									?>
									
                                </tbody>
                            </table>	
						 
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                   
            
