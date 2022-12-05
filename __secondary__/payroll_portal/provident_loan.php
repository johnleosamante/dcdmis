<style>
th,td{
	text-transform:uppercase;
}
</style>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					   	<h2>List of Personnel</h2>
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
                                       
                                        <th width="10%">Sex</th>
                                        <th width="15%">Station</th>
                                        <th width="15%">Position</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status ='Active' ORDER BY Emp_LName Asc");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Emp_LName'].'</td>
											<td>'.$row['Emp_FName'].'</td>
											<td>'.$row['Emp_MName'].'</td>
											
											<td style="text-align:center;">'.$row['Emp_Sex'].'</td>
											<td>'.$row['Abraviate'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td style="text-align:center;">
											 <a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&No='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("provident_account")).'">VIEW</a>
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
              
