
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

            <!-- /.row -->
            <div class="row">
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="print-all.php?link=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9%27&&Print=All" style="float:right;" class="btn btn-primary" target="_blank">Print All</a>                      
						 <a href="print-personnel.php?link=%278ea8355b2e55b6c656245ba15d7fffb3aa1841b9%27" style="float:right;" class="btn btn-primary" target="_blank">Print Personnel</a>                      
						 	<h4> DAILY TIME RECORD INFORMATION</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="6%">#</th>
                                        <th width="15%">Last Name</th>
                                        <th width="15%">First Name</th>
                                        <th width="15%">Middle Name</th>
                                        <th width="10%">Birthdate</th>
                                        <th width="25%">Position</th>
                                        <th width="15%">Section</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE  tbl_station.Emp_Station='123131' AND tbl_employee.Emp_Status = 'Active' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Emp_LName'].'</td>
											<td>'.$row['Emp_FName'].'</td>
											<td> '.$row['Emp_MName'].'</td>
											<td>'.$row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td>'.$row['Office'].'</td>
												
											<td style="text-align:center;">
													
															<!--<a href="my-dtr.php" data-toggle="modal" data-target="#myDTR"><i class="fa  fa-desktop  fa-fw"></i></a>-->
															<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("mydate")).'" target="_blank"><i class="fa  fa-desktop  fa-fw"></i></a>
											
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
                <!-- /.col-lg-12 -->
            </div>
        



<!-- Modal for Re-assign-->
<div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myDTR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog" style="overflow-x:auto;">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
