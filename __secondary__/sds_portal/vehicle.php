<style>
	td,th{
		text-align:center;
	}
</style>
         <div class="col-lg-8">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="print_vts_record.php" class="btn btn-primary" style="float:right;" target="_blank">PRINT REPORT</a>
							<h4>VEHICLE REQUEST RECORDS</h4>
							<?php
							 if (isset($_POST['approved']))
							 {
								 mysqli_query($con,"UPDATE tbl_vehicle_reservation SET RequestStatus='Approved' WHERE No ='".$_SESSION['updatevehicle']."' LIMIT 1");
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
							 }else if (isset($_POST['vehicleout']))
							 {
								 if ($_SESSION['Status']=='IN')
								 {
									mysqli_query($con,"UPDATE tbl_vehicle SET Status='OUT' WHERE VehicleCode='".$_SESSION['vehicleout']."' LIMIT 1");	
								 }else{
									mysqli_query($con,"UPDATE tbl_vehicle SET Status='IN' WHERE VehicleCode='".$_SESSION['vehicleout']."' LIMIT 1");		
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
							 }elseif(isset($_POST['change_vehicle']))
							 {
								  mysqli_query($con,"UPDATE tbl_vehicle_reservation SET VehicleCode='".$_POST['vehicle']."' WHERE No ='".$_SESSION['updatevehicle']."' LIMIT 1");
								
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
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          
                         
						     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="15%">Date</th>
												<th width="15%">Destination</th>
												<th width="15%">Vehicle and Plate Number</th>
												<th width="15%">Driver</th>
												<th width="15%">Requested by</th>
												
											</tr>
										</thead>
									<tbody>	
									<?php
									$no=0;
									$request=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.RequestStatus <> 'For Approval'");
									while($rowre=mysqli_fetch_array($request))
									{
									  $no++;
                                      echo '<tr>
												<td>'.$no.'</td>
												<td>'.$rowre['RequestDate'].'</td>
												<td>'.$rowre['RequestDestination'].'</td>
												<td>'.$rowre['Vehicle_Description'].'-'.$rowre['PlateNo'].'</td>
												<td>'.$rowre['Driver'].'</td>
												<td>'.$rowre['Requestedby'].'</td>
												
											</tr>';									  
									}
									?>
									</tbody>
								</table>									
						   </div>
						   
						
                    </div>
                    <!-- /.panel -->
                </div>
				  <div class="col-lg-4">
				  <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>VEHICLE STATUS</h4>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th>Vehicle Description</th>
												<th width="15%">Driver</th>
												<th width="15%">Ststus</th>
											</tr>
										</thead>
										<?php
										$no=0;
										$result=mysqli_query($con,"SELECT * FROM tbl_vehicle");
										while($row=mysqli_fetch_array($result))
										{
											$no++;
										 echo '<tr>
												<td>'.$no.'</td>
												<td>'.$row['Vehicle_Description'].'</td>
												<td>'.$row['Driver'].'</td>
												<td>'.$row['Status'].'</td>';
												if ($row['Status']=='IN')
												{
												echo '<td><a href="vehicleout.php?code='.$row['VehicleCode'].'&Status=IN" data-toggle="modal" data-target="#viewstatus"><i class="fa fa-desktop"></i></a></td>';
												}else{
													echo '<td><a href="vehicleout.php?code='.$row['VehicleCode'].'&Status=OUT" data-toggle="modal" data-target="#viewstatus"><i class="fa fa-desktop"></i></a></td>';
											
												}
												
											 echo '</tr>';
										}
										?>
									<tbody>	
									</tbody>	
									</table>
                     </div>
                  </div>
				    <div class="panel-heading">
							<h4>VEHICLE NEW REQUEST</h4>
                        </div>
				  
				  <table width="100%" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th>Vehicle Description</th>
												<th width="15%">Driver</th>
												<th width="15%">Ststus</th>
											</tr>
										</thead>
										<?php
										$no=0;
										$requestnew=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.RequestStatus ='For Approval'");
									
										while($rownew=mysqli_fetch_array($requestnew))
										{
											$no++;
										 echo '<tr>
												<td>'.$no.'</td>
												<td>'.$rownew['Vehicle_Description'].'-'.$rownew['PlateNo'].'</td>
												<td>'.$rownew['Driver'].'</td>
												<td>'.$rownew['RequestStatus'].'</td>
												<td><a href="print_vehicle_request.php?code='.$rownew['VehicleCode'].'&No='.$rownew['No'].'&date='.$rownew['RequestDate'].'" data-toggle="modal" data-target="#viewstatus"><i class="fa fa-desktop"></i></a></td>
												
											  </tr>';
										}
										?>
									<tbody>	
									</tbody>	
									</table>
                </div>
                <!-- /.col-lg-12 -->
          
   
 
              <!-- Modal -->
	 <div class="modal fade" id="viewstatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
		

	</div></div>
	</div>
 
