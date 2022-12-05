

	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>Retirable Personnel</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="6%">#</th>
                                        <th width="20%">Name</th>
                                        <th width="10%">Birthdate</th>
                                        <th width="20%">Station</th>
                                        <th width="8%">Age</th>
                                        <th width="15%">Position</th>
                                        <th width="15%">Status</th>
                                        <th width="7%"></th>
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
											
											<td style="text-align:center;">
													
															<a href="view_information.php?id='.$row['Emp_ID'].'" data-toggle="modal" data-target="#myinfo" title="view records"><i class="fa  fa-desktop fa-fw"></i></a>
																
															
														
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
              
<style>
  
   .modal-footer{
	   background-color:#f9f9f9;
   }
   .loginbox{
	   width:700px;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
					}
		}
		th{
			text-align:center;
		}
   </style>


   <!-- Modal for Re-assign-->
   <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
      
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>