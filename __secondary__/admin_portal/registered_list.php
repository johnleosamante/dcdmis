
	<style>
	th,td{
		text-transform:uppercase;
		
	}
	
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	<h4>List of Registered Participants</h4>
								
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
												
								<thead>							
									<tr>
										<th style="text-align:center;width:5%;">#</th>
										<th>District Name</th>
										<th>Level</th>
										<th>School</th>
										<th>Employee Name</th>
										<th>Email Address</th>
										<th>Contact #</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								$no=0;
								$mypersonnel=mysqli_query($con,"SELECT * FROM tbl_seminar_registration INNER JOIN tbl_school ON tbl_seminar_registration.SchoolID = tbl_school.SchoolID INNER JOIN tbl_district ON tbl_seminar_registration.District = tbl_district.District_code");
									
								while($rowpersonnel=mysqli_fetch_array($mypersonnel))
								{
									$no++;
									echo '<tr>
										<td style="text-align:center;width:10%;">'.$no.'</td>
										<td>'.$rowpersonnel['District_Name'].'</td>
										<td>'.$rowpersonnel['Level'].'</td>
										<td>'.$rowpersonnel['SchoolName'].'</td>
										<td>'.$rowpersonnel['First_Name'].' '.$rowpersonnel['MiddleName'].'. '.$rowpersonnel['Last_Name'].'</td>
										<td>'.$rowpersonnel['DepEd_Email'].'</td>
										<td>'.$rowpersonnel['CPNo'].'</td>
										
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
 	  