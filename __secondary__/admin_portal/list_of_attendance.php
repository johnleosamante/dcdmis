<style>
	th,td{
			text-transform:uppercase;
		}
	
</style>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					   <a href="print_attendance.php" style="float:right;" class="btn btn-primary" target="_blank">Print Preview</a>
							<h2>List of Attendance</h2>						
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" rowspan="2" style="text-align:center;">#</th>
												<th width="35%" rowspan="2">NAME</th>
												<th width="35%" rowspan="2">SCHOOL NAME</th>
												<th width="20%" rowspan="2" style="text-align:center;">DATE</th>
												
												<th width="20%" colspan="2" style="text-align:center;">MORNING SESSION</th>
												<th width="20%" colspan="2" style="text-align:center;">AFTERNOON SESSION</th>
												
											</tr>
										<tr>
											<th style="text-align:center;">IN</th>
											<th style="text-align:center;">OUT</th>
											<th style="text-align:center;">IN</th>
											<th style="text-align:center;">OUT</th>
										</tr>										
									</thead>
									<tbody>
									<?php
									$no=0;
									$result=mysqli_query($con,"SELECT * FROM tblseminar_attendance INNER JOIN tbl_employee ON tblseminar_attendance.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON  tblseminar_attendance.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.	Emp_Station = tbl_school.SchoolID  WHERE tblseminar_attendance.datestart='".date("Y-m-d")."'ORDER BY Emp_LName Asc");
									while($row=mysqli_fetch_array($result))
									{
										$no++;
										echo '<tr>
												<td>'.$no.'</td>
												<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
												<td>'.$row['SchoolName'].'</td>
												<td style="text-align:center;">'.$row['datestart'].'</td>
												<td style="text-align:center;">'.$row['MorningIN'].'</td>
												<td style="text-align:center;">'.$row['MorningOUT'].'</td>
												<td style="text-align:center;">'.$row['AfternoonIN'].'</td>
												<td style="text-align:center;">'.$row['AfternoonAOUT'].'</td>
											 </tr>';
											 //mysqli_query($con,"UPDATE tblseminar_attendance SET MorningIN='07:50:00' WHERE datestart='2021-12-15' AND 	Emp_ID='".$row['Emp_ID']."' LIMIT 1");
									}
									/*$result=mysqli_query($con,"SELECT * FROM tblseminar_attendance INNER JOIN tbl_employee ON tblseminar_attendance.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON  tblseminar_attendance.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.	Emp_Station = tbl_school.SchoolID  WHERE tblseminar_attendance.datestart='2021-12-16' AND tblseminar_attendance.MorningOUT='00:00:00' ORDER BY Emp_LName Asc");
									while($row=mysqli_fetch_array($result))
									{
									mysqli_query($con,"UPDATE tblseminar_attendance SET MorningOUT='12:10:00' WHERE datestart='2021-12-16' AND 	Emp_ID='".$row['Emp_ID']."' LIMIT 1");
									}*/
									?>
									</tr>
									</tbody>
									</table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
   