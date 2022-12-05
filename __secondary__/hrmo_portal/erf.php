<?php
if (isset($_POST['disapproved']))
{
	if(mysqli_affected_rows($con)==1)
	{
		mysqli_query($con,"DELETE FROM tbl_online_application WHERE Transaction_number='".$_SESSION['TCode']."' LIMIT 1");
		?>
			<script type="text/javascript">
				$(document).ready(function(){						
				$('#access').modal({
					show: 'true'
				}); 				
				});
			</script>
									
							 
		<?php 
	}
}
?>
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>List of Personnel Qualified for ERF</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Last Name</th>
                                        <th width="15%">First Name</th>
                                        <th width="15%">Middle Name</th>
                                        <th width="10%">Sex</th>
                                        <th width="15%">Station</th>
                                        <th width="15%">Position</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no=0;
								$result=mysqli_query($con,"SELECT * FROM tbl_online_application INNER JOIN tbl_employee ON tbl_online_application.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID  WHERE tbl_online_application.Transaction_office='HRMO'")or die ("Error Query");
								while($row=mysqli_fetch_array($result))
								{
									$no++;
									echo '<tr> <td>'.$no.'</td>
                                        <td>'.$row['Emp_LName'].'</td>
                                        <td>'.$row['Emp_FName'].'</td>
                                        <td>'.$row['Emp_MName'].'</td>
                                        <td>'.$row['Emp_Sex'].'</td>
                                        <td>'.$row['SchoolName'].'</td>
                                        <td>'.$row['Job_description'].'</td>
                                       <td>';
													
															if ($row['Transaction_status']=='For Confirmation and Approval')
															{
															echo '<a href="myconfirmation.php?id='.$row['Transaction_number'].'" data-toggle="modal" data-target="#myEvaluation" class="btn btn-primary" style="padding:4px;margin:4px;" title="For Approval"> <i class="fa  fa-thumbs-o-up   fa-fw"></i></a>
																';
															}elseif ($row['Transaction_status']=='For Evaluation and Assessment')
															{
															echo '<a href="evaluated.php?id='.$row['Transaction_number'].'" data-toggle="modal" data-target="#myEvaluation" style="padding:4px;margin:4px;" class="btn btn-info" title="For Evaluation" > Evaluated</a>
																';	
															}																
															echo '<a href="disapproved.php?id='.$row['Transaction_number'].'" data-toggle="modal" data-target="#myEvaluation" class="btn btn-danger" style="padding:4px;margin:4px;" title="Disapproved"><i class="fa  fa-thumbs-o-down   fa-fw"></i></a>
																
														
													</td></tr>';
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
           
  
	
	
				  
<div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myEvaluation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
       
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
	  </div>
	</div>