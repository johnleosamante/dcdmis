<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$_SESSION['vehicleout']	= $_GET['code'];	
$_SESSION['Status']	= $_GET['Status'];			
?>
	<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Vehicle Information</h4>
			</div>
			<form action="" method="POST"> 
			<div class="modal-body">
			<?php
			
			$vehicle=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.VehicleCode='".$_GET['code']."' AND tbl_vehicle_reservation.RequestDate='".date('Y-m-d')."' LIMIT 1") or die("Table Error");
			 $rowvh=mysqli_fetch_assoc($vehicle);
		   echo' <label>Driver:</label>
			   <input type="text" class="form-control" value="'.$rowvh['Driver'].'" style="text-transform:uppercase;"disabled>
			   <label>Vehicle Description:</label>
			   <input type="text" class="form-control" value="'.$rowvh['Vehicle_Description'].'" style="text-transform:uppercase;" disabled>
			   <label>Plate Number:</label>
			   <input type="text" class="form-control" value="'.$rowvh['PlateNo'].'" disabled>
			   <label>Destination:</label>
			   <input type="text" class="form-control" value="'.$rowvh['RequestDestination'].'" disabled>
			    <label>Purpose(s):</label>
			   <input type="text" class="form-control" value="'.$rowvh['RequestPurposed'].'" disabled>
			    <label>Passenger(s):</label>
			   <input type="text" class="form-control" value="'.$rowvh['RequestPassenger'].'" disabled>
			   ';
			   ?>
		   	</div>
           <div class="modal-footer">
		   <?php
		   if ($_GET['Status']=='IN')
		   {
		   echo '<input type="submit" name="vehicleout" value="OUT" class="btn btn-primary">';
		   }else{
		   echo '<input type="submit" name="vehicleout" value="IN" class="btn btn-primary">';
		   }
		   ?>
		    <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload();">Close</button>
			</form>
		 </div>	