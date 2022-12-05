 <?php
if (isset($_POST['disapproved']))
{
mysqli_query($con,"DELETE FROM tbl_step_increment WHERE tbl_step_increment.Emp_ID='".$_SESSION['TCode']."' LIMIT 1");
	
if(mysqli_affected_rows($con)==1)
	{
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
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>List of Personnel Qualified for Step Increment</h4>
							
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
								 $result=mysqli_query($con,"SELECT * FROM tbl_step_increment INNER JOIN tbl_employee ON tbl_step_increment.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_step_increment.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID")or die ("Error query data");
								 while($row=mysqli_fetch_array($result))
								 {
									 $no++;
									 echo '<tr>
											<td>'.$no.'</td>
											<td>'.$row['Emp_LName'].'</td>
											<td>'.$row['Emp_FName'].'</td>
											<td>'.$row['Emp_MName'].'</td>
											<td>'.$row['Emp_Sex'].'</td>
											<td>'.$row['Abraviate'].'</td>
											<td>'.$row['Job_description'].'</td>
											 <td>
											    <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($row['Emp_ID'])).'&v='.urlencode(base64_encode("stepapproval")).'" class="btn btn-primary" style="padding:4px;margin:4px;" title="For Approval"> <i class="fa  fa-thumbs-o-up   fa-fw"></i></a>
											    <a href="remove_step.php?id='.$row['Emp_ID'].'" data-toggle="modal" data-target="#myApproval" class="btn btn-danger" style="padding:4px;margin:4px;" title="Disapproved"><i class="fa  fa-thumbs-o-down   fa-fw"></i></a>
																
																		
														
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
          
   
  
			  
			  
			  <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myApproval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
       
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
	  </div>
	</div>