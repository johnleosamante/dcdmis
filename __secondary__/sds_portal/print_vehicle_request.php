<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
$_SESSION['currentvehicle']	= $_GET['code'];	
$_SESSION['updatevehicle']	= $_GET['No'];	
				
?>
	<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Vehicle Information</h4>
			</div>
			<form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			<?php
			
			$vehicle=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.VehicleCode='".$_GET['code']."' AND tbl_vehicle_reservation.RequestDate='".$_GET['date']."' AND tbl_vehicle_reservation.RequestStatus = 'For Approval' LIMIT 1") or die("Table Error");
			 $rowvh=mysqli_fetch_assoc($vehicle);
		   echo' <label>Driver:</label>
			   <input type="text" class="form-control" value="'.$rowvh['Driver'].'" style="text-transform:uppercase;"disabled>
			   <label>Vehicle Description:</label>
			   <input type="text" class="form-control" value="'.$rowvh['Vehicle_Description'].'" style="text-transform:uppercase;" disabled>
			   <label>Plate Number:</label>
			   <input type="text" class="form-control" value="'.$rowvh['PlateNo'].'" disabled>
			    <label>Date to Travel:</label>
			   <input type="text" class="form-control" value="'.$rowvh['RequestDate'].'" disabled>
			   <label>Destination:</label>
			   <input type="text" class="form-control" value="'.$rowvh['RequestDestination'].'" disabled>
			    <label>Purpose(s):</label>
			   <input type="text" class="form-control" value="'.$rowvh['RequestPurposed'].'" disabled>
			    <label>Passenger(s):</label>
			   <input type="text" class="form-control" value="'.$rowvh['RequestPassenger'].'" disabled>
			   ';
			   $_SESSION['Requestedby']=$rowvh['Requestedby'];
			   ?>
		   	</div>
           <div class="modal-footer">
		   <a onclick="cancelme(this.id)" class="btn btn-warning">Cancel</a>
		   <a href="#myvehicle" class="btn btn-info" data-toggle="modal">Change Vehicle</a>
		   <a onclick="disapprovedme(this.id)" class="btn btn-danger">Disapproved</a>
		   <input type="submit" name="approved" value="Approved" class="btn btn-primary">
		   <?php
		   echo '<a href="print_request_form.php?code='.$rowvh['RequestDate'].'" target="_blank" class="btn btn-success">Print</a>';
		   ?>
		   <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload()">Close</button>
			</form>
		 </div>	
		 
	<script>
		function disapprovedme(id)
		{
			if (confirm("Are you sure you want disapprove this request?"))
			{
				alert("Successfully Disapproved");
				window.location.href="disapprovedrequest.php";
			}
		}
	</script>	
	
	<script>
		function cancelme(id)
		{
			if (confirm("Are you sure you want Cancel this request?"))
			{
				alert("Successfully canceled");
				window.location.href="disapprovedrequest.php";
			}
		}
	</script>	
	          <!-- Modal -->
	 <div class="modal fade" id="myvehicle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">Change Vehicle Information</h4>
			</div>
			<form action="" Method="POST" enctype="multipart/form-data">
			<div class="modal-body">
			<label>Change Vehicle</label>
			<select name="vehicle" class="form-control" required>
			<option value="">--Select Vehicle--</option>
			  <?php
                $newvehicle=mysqli_query($con,"SELECT * FROM tbl_vehicle");
				while($rowve=mysqli_fetch_array($newvehicle))
				{
					echo '<option value="'.$rowve['VehicleCode'].'">'.$rowve['Vehicle_Description'].'</option>';
				}
			   ?>
			   </select>
		   	</div>
           <div class="modal-footer">
		    <input type="submit" name="change_vehicle" value="Change Vehicle" class="btn btn-primary">
		     <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload()">Close</button>
			</form>
		 </div>	
		 
		

	</div></div>
	</div>