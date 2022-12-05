
	<style>
	th,td{
		text-transform:uppercase;
		
	}
	
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code=TUlTLTIwMjIzMTA1NDg%3D&v=dmlld19saXN0" class="btn btn-secondary" style="float:right;">Back</a>
						 	 <?php
						
							 echo  '<label>Training Code:</label>
									<label>'.$_SESSION['TrainingCode'].'</label><br/>
								
									
									';
							
							
							?>
								
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
												
								<thead>							
									<tr>
										<th style="text-align:center;width:10%;">EmpNo</th>
										<th>Employee Name</th>
										<th width="25%">Position Title</th>
										<th width="5%"></th>
									</tr>
								</thead>
								<tbody>
								<?php
								$mypersonnel=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status ='Active' ORDER BY tbl_employee.Emp_LName Asc");
									
								while($rowpersonnel=mysqli_fetch_array($mypersonnel))
								{
									echo '<tr>
										<td>'.$rowpersonnel['Emp_ID'].'</td>
										<td>'.$rowpersonnel['Emp_LName'].', '.$rowpersonnel['Emp_FName'].', '.$rowpersonnel['Emp_MName'].'</td>
										<td>'.$rowpersonnel['Job_description'].'</td>
										<td style="text-align:center;"><a href="add_participant.php?code='.urlencode(base64_encode($rowpersonnel['Emp_ID'])).'">Add</a></td>
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
        
		
	
		
				 <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="editnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
     <!-- Modal content-->
      <div class="modal-content">
    
    
	</div>
	</div>
	</div>
</div>
      
	  
	  
	
				
				
				 <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="addrecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Successfully Save!</center></h3>
		 
        </div>
        <div class="modal-body">

              <center>
			<img src="../logo/check.png" width="100%" height="30%">
			
			 <?php
		  
			echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($_GET['Code'])).'&v='.urlencode(base64_encode("view_payroll_record")).'" class="btn btn-success"> NEXT</a>';
		   
		   ?>
		   </center>
		   	</div>
           

	</div></div>
	</div>
	</div>
 	  