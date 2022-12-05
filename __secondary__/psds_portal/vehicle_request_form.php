<?php
date_default_timezone_set("Asia/Manila");
$_SESSION['vehicle']=$_GET['vcode'];
if (isset($_POST['saverequest']))
{
	$Destination=$_POST['destination'];
	$Destination=str_replace("'","\'",$Destination);	
	
	$purpose=$_POST['purpose'];
	$purpose=str_replace("'","\'",$purpose);
	mysqli_query($con,"INSERT INTO tbl_vehicle_reservation VALUES(NULL,'".$_POST['datetotravel']."','".$Destination."','".$purpose."','".$_POST['timeleaving']."','".$_POST['timereturn']."','".$_POST['passenger']."','".$_POST['requestedby']."','".$_GET['vcode']."','For Approval','".$_SESSION['station']."')");
	if (mysqli_affected_rows($con)==1)
	{
		 echo '<div class="alert alert-success">
                  <h4>Request is successfully submitted. Please wait for the approval.</h4>
				  <a href="./" class="btn btn-primary">Continue</a>
               </div>';
	}
	exit;
}
?>
	    <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">		
					<h4>VEHICLE INFORMATION</h4>	
                </div>
                        
                        <!-- /.panel-heading -->
                    <div class="panel-body">
						<?php
						 $vehicle=mysqli_query($con,"SELECT * FROM tbl_vehicle WHERE VehicleCode='".$_GET['vcode']."' LIMIT 1");
						 $rowvh=mysqli_fetch_assoc($vehicle);
						 $date = date('M j\, Y', strtotime($_SESSION['daterequest']));
					   echo' <label>Driver:</label>
						   <input type="text" class="form-control" value="'.$rowvh['Driver'].'" style="text-transform:uppercase;"disabled>
						   <label>Vehicle Description:</label>
						   <input type="text" class="form-control" value="'.$rowvh['Vehicle_Description'].'" style="text-transform:uppercase;" disabled>
						   <label>Plate Number:</label>
						   <input type="text" class="form-control" value="'.$rowvh['PlateNo'].'" disabled>
							 <label>Date Travel:</label>
						   <input type="text" class="form-control" value="'.$date.'" disabled>';
						   ?>
                    </div>  
		  </div> 
	  </div>  
	
 <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">		
					<h4>VEHICLE REQUEST INFORMATION</h4>
                </div>
                        
                        <!-- /.panel-heading -->
                    <div class="panel-body">
						<?php
							$query=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation WHERE RequestDate='".$_SESSION['daterequest']."' AND VehicleCode='".$_SESSION['vehicle']."' AND RequestStatus='For Approval'");
								if (mysqli_num_rows($query)==1)
								{
									$row=mysqli_fetch_assoc($query);
									echo '<h4>Vehicle not available.<br/> Reserved by: '.$row['Requestedby'].'</h4><hr/>';
									echo '<h4>CHANGE VEHICLE REQUEST</h4><div class="row">';
								$result=mysqli_query($con,"SELECT * FROM tbl_vehicle WHERE Status <>'OUT'");
									while($row=mysqli_fetch_array($result))
									{
										
										echo '<div class="col-xl-3 col-md-6">
											<div class="card bg-'.$row['VColor'].' text-white mb-4">
												<div class="card-body" style="text-transform:uppercase;">'.$row['Vehicle_Description'].'</div>
												<div class="card-footer d-flex align-items-center justify-content-between">
												<a class="small text-white stretched-link" href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&vcode='.urlencode(base64_encode($row['VehicleCode'])).'&v='.urlencode(base64_encode("vehicle_request_form")).'">Continue</a>
												
													<div class="small text-white"><i class="fas fa-angle-right"></i></div>
												</div>
											</div>
										</div>';
										
									}
									echo '<a href="./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=cmVxdWVzdF9mb3JfdmVoaWNsZQ%3D%3D" class="btn btn-secondary" style="float:right;">Back</a></div>';
								}else{
									echo '<form action="" Method="POST" enctype="multipart/form-data">
									
										  <input type="hidden" name="datetotravel" class="form-control" value="'.$_SESSION['daterequest'].'" required>
										  <label>Destination:</label>
										  <input type="text" name="destination" class="form-control" required>
										  <label>Purpose(s):</label>
										  <textarea name="purpose" class="form-control" rows="2" required></textarea>
										  <label>Time Out:</label>
										  <input type="time" name="timeleaving" class="form-control" required>
										  <label>Time In:</label>
										  <input type="time" name="timereturn" class="form-control" required>
										  <label>Passenger(s):</label>
										  <textarea name="passenger" class="form-control" rows="2" required></textarea>
										  <label>Requested by:</label>
										  <input type="text" name="requestedby" class="form-control" required>
										
										   </div>
										 <div class="modal-footer">
										  <input type="submit" name="saverequest" class="btn btn-primary">
										  <a href="./?13b714fad9eca2a00fe69ce8ce03cba1c7e085277e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v=cmVxdWVzdF9mb3JfdmVoaWNsZQ%3D%3D" class="btn btn-default" style="float:right;">Back</a>
										</div></form>';
								}
							?>
                    </div>  
		  </div> 
	  </div>  