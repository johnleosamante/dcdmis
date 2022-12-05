

	<style>
	th{
		text-transform:uppercase;
	}
	</style>

          
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 
							<h4>List of Personnel Registered</h4>
							
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
                                        <th width="5%">Extension</th>
                                        <th width="10%">Sex</th>
                                        <th width="15%">Station</th>
                                        <th width="15%">Position</th>
                                        <th width="7%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
									$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status ='Registered' ORDER BY Emp_LName Asc");
									while($row=mysqli_fetch_array($myinfo))
									{
										$no=$no+1;
                                      echo '<tr class="gradeA">
											<td style="text-align:center;">'.$no.'</td>
											<td>'.$row['Emp_LName'].'</td>
											<td>'.$row['Emp_FName'].'</td>
											<td>'.$row['Emp_MName'].'</td>
											<td style="text-align:center;">'.$row['Emp_Extension'].'</td>
											<td style="text-align:center;">'.$row['Emp_Sex'].'</td>
											<td>'.$row['Abraviate'].'</td>
											<td>'.$row['Job_description'].'</td>
											<td style="text-align:center;">
													
														';
															
															echo'
															<a href="confirm_account.php?id='.urlencode(base64_encode($row['Emp_ID'])).'" data-toggle="modal" data-target="#myupdate"> ACCEPT</a>
															<a  style="cursor:pointer;" onclick="delete_data(this.id)" id="'.$row['Emp_ID'].'"> DECLINE</a>
																
																';
																
																
															echo '
														
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
   .deploy{
	   width:800px;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
   }
   .loginbox{
	   width:1000px;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					.deploy{
							width:100%;height:auto;margin-top:50px;margin-left:auto;margin-right:auto;
							}
			}
		
   </style>


<!-- Modal for Re-assign-->
<div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>


<script>
function delete_data(id)
{
	if (confirm("Are you sure you want to delete this record?"))
	{
		window.location.href="delete_employee.php?id="+id;
	}
}
</script>