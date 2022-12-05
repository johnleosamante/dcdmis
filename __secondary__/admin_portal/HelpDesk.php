
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       <div class="panel-heading">
					    	<h2>List of request</h2>
													
					   </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="10%">Ticket No</th>
												<th width="30%">Query Description</th>
												<th width="20%" >Date Request</th>
												<th width="20%">Request By</th>
												<th width="10%">Station</th>
												<th width="5%"></th>
											</tr>
																			
									</thead>
									<tbody>
									
									<?php
									$no=0;
									$seminar=mysqli_query($con,"SELECT * FROM tbl_school_query INNER JOIN tbl_employee ON tbl_school_query.PostedBy = tbl_employee.Emp_ID INNER JOIN tbl_school ON tbl_school_query.SchoolID = tbl_school.SchoolID") or die ("error training data");
										while($row=mysqli_fetch_array($seminar))
										{
											
										echo '<tr><td>'.$row['TicketNo'].'</td>
												<td>'.$row['Messages'].'</td>
												<td>'.$row['date_posted'].'</td>
												<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>
												<td>'.$row['Abraviate'].'</td>
												<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&id='.urlencode(base64_encode($row['TicketNo'])).'&v='.urlencode(base64_encode("requestReply")).'">View</a></td>
												
												</tr>
												';
										}
													?>
									</tr>
									</tbody>
									</table>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
              
<style>
   .modal-header,h4, .close{
	   background-color:#f9f9f9;
	   color:black !important;
	   text-align:center;
	   font-size:30px;
   }
   .modal-footer{
	   background-color:#f9f9f9;
	   text-align:left;
   }
   
   .loginbox{
	   width:50%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
   .memobox{
	   width:70%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
   }
		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {
			 .loginbox{
						width:100%;height:auto;margin-top:100px;margin-left:auto;margin-right:auto;
					}
					.memobox{
						   width:100%;height:auto;margin-top:10px;margin-left:auto;margin-right:auto;
					   }
					
			}
		
   </style>


<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="myparti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
		

<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mymemo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
			  
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="mytraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>ADD NEW TRAINING</center></h3>
		  	
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>TRAININGS CODE:</label>
		<input type="text" class="form-control" value="<?php  echo $_SESSION['station'].'-'.date('Ydms'); ?>" disabled>
		<input type="hidden" name="Tcode" class="form-control" value="<?php  echo $_SESSION['station'].'-'.date('Ydms'); ?>" >
		<label>TITLE OF TRAININGS / ACTIVITIES:</label>
		<textarea name="TTitle" class="form-control" rows="3" required autofocus></textarea>
		
		<label>FROM:</label>
		<input type="date" name="TFrom" class="form-control" required>
		<label>TO:</label>
		<input type="date" name="TTo" class="form-control" required>
		<label>CONDUCTED BY:</label>
		<select name="TConduct" class="form-control">
		<option value="">--Select--</option>
		<option value="DepEd-City">DepEd City </option>
		<option value="DepEd-Region">DepEd Region</option>
		</select>
		<label>VENUE:</label>
		<input type="text" name="TVenue" class="form-control" required>
		<label>OFFICE:</label>
		<input type="text" class="form-control" value="<?php echo $_SESSION['station']; ?>" disabled>
		<input type="hidden" name="TOffice" class="form-control" value="<?php echo $_SESSION['station']; ?>">
		</div>
		 <div class="modal-footer">
		<input type="submit" name="training-data" Value="SUBMIT" class="btn btn-success">
		</div>
		</form>
		
		      </div>
		      </div>
			  </div></div>
		
