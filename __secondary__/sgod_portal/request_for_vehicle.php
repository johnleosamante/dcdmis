<script>
		function view_vehicle(str){
					
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("txtdata").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","list_of_vehicle_available.php?id="+str,false);
		  xmlhttp.send();
		}
	</script>
	    <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
			       <a href="#myrequest" class="btn btn-default" data-toggle="modal" style="float:right;"><i class="fa fa-user fa-fw"></i>New Request</a>
					<h4>TRAVEL REQUEST MASTERLIST</h4>
							
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
										<th width="15%">Status</th>
										<th width="7%"></th>
																						
									</tr>
                                </thead>
                                <tbody>
								<?php
									$no=0;
									$request=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation INNER JOIN tbl_vehicle ON tbl_vehicle_reservation.VehicleCode = tbl_vehicle.VehicleCode WHERE tbl_vehicle_reservation.Office='".$_SESSION['station']."' ORDER BY tbl_vehicle_reservation.RequestStatus Desc");
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
												<td>'.$rowre['RequestStatus'].'</td>';
												if ($rowre['RequestStatus']<>'Approved')
												{
													echo '<td><a href="print_request_form.php?code='.$rowre['VehicleCode'].'&No='.$rowre['No'].'&date='.$rowre['RequestDate'].'" target="_blank"> <i class="fa  fa-print  fa"></a></td>';
												}else{
													echo '<td></td>';
												}
											echo '</tr>';									  
									}
									?>
                                </tbody>
								</table>
			
                    </div>  
		  </div> 
	  </div>  
				
       <!-- Modal -->
	 <div class="modal fade" id="myrequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			
			<h4 class="modal-title" id="myModalLabel">VEHICLE REQUEST FORM</h4>
			</div>
			 
			<div class="modal-body">
			<label>DATE TO TRAVEL</label>
			<input type="date" name="traveldate" class="form-control" onchange="view_vehicle(this.value)">	
			<div id="txtdata"></div>
		   	</div>
           <div class="modal-footer">
		  	   <button type="button" class="btn btn-default" aria-hidden="true" data-dismiss="modal" onclick="window.location.reload()">Close</button>
			</center>
		 </div>	

	</div></div>
	</div>
					