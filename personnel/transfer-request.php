<style>
label,th,td{
	text-transform:uppercase;
}
</style>
<h2>REQUEST FOR TRANSFER RECORDS</h2><hr/>
<?php
if (isset($_POST['updatemyposition']))
{
	$query=mysqli_query($con,"SELECT * FROM tbl_deployment_history WHERE Emp_ID ='".$_SESSION[GetSiteAlias() . '_EmpID']."' AND position_assign='".$_POST['newposition']."' AND station_assign='".$_SESSION[GetSiteAlias() . '_SchoolID']."'");
	if (mysqli_num_rows($query)==0)
	{
	 mysqli_query($con,"UPDATE tbl_station SET Emp_Position='".$_POST['newposition']."' WHERE Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."' LIMIT 1");
	 mysqli_query($con,"INSERT INTO tbl_deployment_history(Date_assignment,station_assign,position_assign,No_of_years,StepNo,Emp_ID) VALUES('".$_POST['date_of_assignment']."','".$_SESSION[GetSiteAlias() . '_SchoolID']."','".$_POST['newposition']."','0','1','".$_SESSION[GetSiteAlias() . '_EmpID']."')");
	}
	if (mysqli_affected_rows($con)==1)
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
}elseif(isset($_POST['updatemyappointment']))
{
	mysqli_query($con,"UPDATE tbl_station SET Emp_DOA='".$_POST['DOA']."' WHERE Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."' LIMIT 1");
	if (mysqli_affected_rows($con)==1)
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
	<div class="col-lg-4">
<div class="panel-body">
<?php
$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."' LIMIT 1");
$row=mysqli_fetch_assoc($result);
$date = date('F j\, Y', strtotime($row['Emp_DOA']));
$bdate = date('F j\, Y', strtotime($row['Emp_Month'].'/'.$row['Emp_Day'].'/'.$row['Emp_Year']));
$age=date("Y")-$row['Emp_Year'];
   echo '<label>Name:</label><input type="text" class="form-control" value="'.$row['Emp_LName'].', '.$row['Emp_FName'].'" disabled>
	<label>Date of birth:</label><input type="text" class="form-control" value="'.$bdate.'"disabled>
	<label>Age:</label><input type="text" class="form-control" value="'.$age.'"disabled>
	<label>Contact Number:</label><input type="text" class="form-control" value="'.$row['Emp_Cell_No'].'"disabled>
	<label>Address:</label><input type="text" class="form-control" disabled value="'.$row['Emp_Address'].'">
	<label>Position:</label><input type="text" class="form-control"disabled value="'.$row['Job_description'].'"><a href="#updateposition" data-toggle="modal">Change</a><br/>
	<label>Date of Original Appointment:</label><input type="text" class="form-control"disabled value="'.$date.'"><a href="#updateappointment" data-toggle="modal">Change</a>';
?> 
 </div>
  </div>
  
  <div class="col-lg-8">
   <h4>DEPLOYMENT HISTORY</h4><hr/>
  <table width="100%" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="text-align:center;">#</th>
				<th>Date of Assignment</th>
				<th>School Assigned</th>
				<th>Years in service</th>
				<th>Position</th>
				<th>Subject Area</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$no=0;
		$myhistory=mysqli_query($con,"SELECT * FROM tbl_deployment_history INNER JOIN tbl_school ON tbl_deployment_history.station_assign = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_deployment_history.position_assign=tbl_job.Job_code WHERE tbl_deployment_history.Emp_ID='".$_SESSION[GetSiteAlias() . '_EmpID']."'");
		while($rowhist=mysqli_fetch_array($myhistory))
		{
			$no++;
			echo '<tr>
					<td>'.$no.'</td>
					<td>'.$rowhist['Date_assignment'].'</td>
					<td>'.$rowhist['SchoolName'].'</td>
					<td style="text-align:center;">'.$rowhist['No_of_years'].'</td>
					<td style="text-align:center;">'.$rowhist['Job_description'].'</td>
					<td>'.$rowhist['SubjectArea'].'</td>
				  </tr>';
		}
		?>
		</tbody>
		
	</table>
  </div>

<div class="col-lg-12">
<a href="#newrequest" class="btn btn-primary" style="float:right;" data-toggle="modal">NEW RFT</a>
<h2>PENDING REQUEST FOR TRANSFER</h2>
 <div class="panel-body">	
	<table width="100%" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th style="text-align:center;">#</th>
				<th>Date Requested</th>
				<th>Current school</th>
				<th>Years in service</th>
				<th>School to transfer</th>
				<th>Reason for Transfer</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		
	</table>
 </div>
</div>

                            
                            <!-- Modal -->
							 <div class="panel-body">
                            
								<!-- Modal -->
							 <div class="modal fade" id="updateposition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                   <div class="modal-content">
									  <div class="modal-header">
									
									  <h3 class="modal-title"><center>Update my position</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>Select Position:</label>
									<select name="newposition" class="form-control" placeholder="Select Position" required>
										<option value="">--select--</option>
										<?php
										 $mynewpost=mysqli_query($con,"SELECT * FROM tbl_job ORDER BY Job_description Asc");
										 while($rowpost=mysqli_fetch_array($mynewpost))
										 {
											 echo '<option value="'.$rowpost['Job_code'].'">'.$rowpost['Job_description'].'</option>';
										 }
										?>
									</select>									
									<label>Date of Assignment:</label>
									<input type="date" name="date_of_assignment" class="form-control" required>
                                    </div>
									<div class="modal-footer">
									  <input type="submit" name="updatemyposition" value="UPDATE" class="btn btn-primary">
									  <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									  </div>
                                    </form>	
									<!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        
						
						<!-- Modal -->
							 <div class="panel-body">
                            
								<!-- Modal -->
							 <div class="modal fade" id="updateappointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                   <div class="modal-content">
									  <div class="modal-header">
									
									  <h3 class="modal-title"><center>Update my Date of Original Appointment</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
																	
									<label>Date of Original Appointment:</label>
									<input type="date" name="DOA" class="form-control" required>
                                    </div>
									<div class="modal-footer">
									  <input type="submit" name="updatemyappointment" value="UPDATE" class="btn btn-primary">
									  <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									  </div>
                                    </form>	
									<!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        
						
			<!-- Modal -->
							 <div class="panel-body">
                            
								<!-- Modal -->
							 <div class="modal fade" id="newrequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
							 <div class="modal-dialog">
    
                                   <div class="modal-content">
									  <div class="modal-header">
									
									  <h3 class="modal-title"><center>New Request for Transfer Information</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
																	
									<label>Date request:</label>
									<input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" disabled>
									<input type="hidden" name="DRT" class="form-control" value="<?php echo date("Y-m-d");?>" >
									<label>Transfer to:</label>
									<input type="text" name="transferto" class="form-control" required>
									<label># of years render:</label>
									<input type="text" name="no_of_years" class="form-control" required>
									<label>Reason to Transfer:</label>
									<textarea name="reason_to_transfer" class="form-control" required rows="2"></textarea>
                                    <label>Subject Areas:</label>
									<input type="text" name="SubjectArea" class="form-control" required>
									
									</div>
									<div class="modal-footer">
									  <input type="submit" name="newrequest" value="SENT" class="btn btn-primary">
									  <button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									  </div>
                                    </form>	
									<!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        			