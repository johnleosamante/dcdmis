

	<style>
		th{
			text-align:center;
		}
	</style>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Retirable Personnel Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="6%">#</th>
                                        <th width="20%">Name</th>
                                        <th width="10%">Birthdate</th>
                                        <th width="30%">Station</th>
                                        <th width="8%">Age</th>
                                        <th width="15%">Position</th>
                                        <th width="15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_station.Emp_age>='60' AND tbl_employee.Emp_Status <>'Retired'ORDER BY Emp_LName Asc")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].' '.$row['Emp_MName'].'</td>
											<td>'.$row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year'].'</td>
											<td>'.$row['SchoolName'].'</td>
											<td style="text-align:center;">'.$row['Emp_age'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td style="text-align:center;">'.$row['Emp_Status'].'</td>
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
           