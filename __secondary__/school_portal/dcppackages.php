<?php
if (isset($_POST['newbatch']))
{
	mysqli_query($con,"INSERT INTO tbl_batches VALUES(NULL,'".$_POST['batchno']."','".$_POST['yeardelivered']."','".$_POST['packagetype']."','".$_POST['DR']."','".$_POST['IAR']."','".$_POST['IRP']."','".$_POST['PTR']."','".$_SESSION['school_id']."')");
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
}elseif(isset($_POST['newnondcp']))
{
	mysqli_query($con,"INSERT INTO tbl_non_dcp VALUES(NULL,'".$_POST['hardwaretype']."','".$_POST['qty']."','".$_POST['donated']."','".$_POST['Outsourced']."','".$_POST['donatedby']."','".$_SESSION['school_id']."')");
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
}elseif(isset($_POST['newchsstatus']))
{
	mysqli_query($con,"INSERT INTO tbl_chs_status VALUES(NULL,'".$_POST['hardwaretype']."','".$_POST['dcpqty']."','".$_POST['donatedqty']."','".$_POST['outsourceqty']."','".$_POST['QTYworking']."','".$_POST['QTYnonworking']."','".$_POST['remarks']."','".$_SESSION['school_id']."')") or die("Error");
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
 <div class="row">
                <div class="col-lg-12">
                    <h1 ></h1>
                </div>
                <!-- /.col-lg-12 -->
         </div>
            <div class="col-lg-12">
			 <p style="padding:4px;margin:4px;">(as per Regional Order No. 02 s.2018)</p>
                    <div class="panel panel-default">
					   <p style="text-align:center;font-size:24px;"><b>ICT M & E TEMPLATE</b></p>
					   <p style="text-align:center;">A tools for Monitoring and Evaluation of ICT Programs and Projects for</p>
					   <p style="text-align:center;">Department of Education Region IX</p>
                     </div>
			 </div>
			      <div class="col-lg-12">
				  <b> A. BASIC DETAILS</b><hr/>
				   <table width="100%">
				   <tr>
				      <td width="15%">
					    SchoolID:
				     </td>
					  <td>
					   <?php echo $_SESSION['school_id']; ?>
				     </td>
					</tr>
					  <tr>
					   <td width="15%">
						SchoolName: 
					   </td>
					   <td>
					      <?php echo $_SESSION['SchoolName']; ?>
					   </td>
					</tr>
					<tr>
					   <td width="15%">
				        School Head:
				       </td>
					   <td>
					   <?php echo $_SESSION['Principal']; ?>
				       </td>
					</tr>
					 <tr>
					   <td width="15%">
				        ICT Coordinator:
				      </td>
					    <td>
					     
				      </td>
					</tr>
					<tr>
					   <td width="15%">
				         Property Custodian:
				      </td>
					  <td>
					  
				      </td>
					</tr>
					
				   </table><br/>
				    <ul class="nav nav-tabs">
                                <li class="active">
									<a href="#dcp" data-toggle="tab"> B. DCP EQUIPMENT DETAILS</a>
                                </li>
                                <li>
									<a href="#non-dcp" data-toggle="tab"> C. NON-DCP EQUIPMENT DETAILS</a>
                                </li>
								<li>
									<a href="#chps" data-toggle="tab"> D. COMPUTER HARDWARE PHYSICAL STATUS</a>
                                </li>
								<li>
									<a href="#e-class" data-toggle="tab"> E. E-CLASSROOM / LABORATORY CONDITION</a>
                                </li>
						</ul>
				   <div class="tab-content">
                       <div class="tab-pane fade in active" id="dcp">
					   <a href="#mybatch" data-toggle="modal" style="float:right;" class="btn btn-primary">Add</a>
						<h4 class="page-header">B. DCP EQUIPMENT DETAILS (if school is a recipient). Please take note of the latest 2 deliveries in the school.</h4>
						
					   <table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="text-align:center;">Batch #</th>
								<th style="text-align:center;">Year Delivered</th>
								<th style="text-align:center;">Package Type</th>
								<th style="text-align:center;">Delivery Receipt Available?</th>
								<th style="text-align:center;">Inspection and Acceptance Report Available?</th>
								<th style="text-align:center;">Inspection Receipt of Property Available?</th>
								<th style="text-align:center;">Property Transfer Receipt Available?</th>
								<th width="5%"></th>
							</tr>
						</thead>
						<tbody>
						<?php
							
						$batches=mysqli_query($con,"SELECT * FROM tbl_batches WHERE SchoolID='".$_SESSION['school_id']."'");
						while($rowbatch=mysqli_fetch_array($batches))
						{
							
							echo '<tr>
								<td style="text-align:center;">'.$rowbatch['BatchNo'].'</td>
								<td style="text-align:center;">'.$rowbatch['YearDelivered'].'</td>
								<td style="text-align:center;">'.$rowbatch['PackageType'].'</td>
								<td style="text-align:center;">'.$rowbatch['DR_Available'].'</td>
								<td style="text-align:center;">'.$rowbatch['IAR_Available'].'</td>
								<td style="text-align:center;">'.$rowbatch['IRP_Available'].'</td>
								<td style="text-align:center;">'.$rowbatch['PTR_Available'].'</td>
								<td width="5%"><a href="">VIEW</a></td>
							</tr>';
						}	
						?>
							
						</tbody>
						
					   </table>
					</div>
						
						
						<div class="tab-pane fade" id="non-dcp">   
						   <a href="#mynondcp" data-toggle="modal" style="float:right;" class="btn btn-primary">Add</a>
						  <h4 class="page-header">C. NON-DCP EQUIPMENT DETAILS (if school is a recipient).</h4>
						    <table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="text-align:center;" rowspan="2">Hardware Type</th>
								<th style="text-align:center;" rowspan="2" width="10%">Quantity</th>
								<th style="text-align:center;" colspan="2" width="20%">Acquired Through</th>
								<th style="text-align:center;" rowspan="2" width="20%">Donated by / Outsourced from</th>
								
							</tr>
							<tr>
								<th style="text-align:center;" >Donated</th>
								<th style="text-align:center;" >Outsourced</th>
							</tr>
							
						</thead>
						<tbody>
						<?php
						$nondcp=mysqli_query($con,"SELECT * FROM tbl_non_dcp WHERE SchoolID='".$_SESSION['school_id']."'");
						while($rownondcp=mysqli_fetch_array($nondcp))
						{
							echo '<tr>
								<td style="text-align:center;">'.$rownondcp['Item_Type'].'</td>
								<td style="text-align:center;">'.$rownondcp['QTY'].'</td>
								<td style="text-align:center;">'.$rownondcp['Donatedby'].'</td>
								<td style="text-align:center;">'.$rownondcp['Outsource'].'</td>
								<td style="text-align:center;">'.$rownondcp['Person_donated'].'</td>
								
							</tr>';
						}
						?>
						</tbody>
					   </table>
						</div>
				  
						<div class="tab-pane fade" id="chps">   
						    <a href="#mychps" data-toggle="modal" style="float:right;" class="btn btn-primary">Add</a>
						  <h4 class="page-header">D. COMPUTER HARDWARE PHYSICAL STATUS</h4>
						    <table width="100%" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th style="text-align:center;" rowspan="2">Hardware Type</th>
								<th style="text-align:center;" colspan="3" width="30%">Total Quantity (based from DR)</th>
								<th style="text-align:center;" rowspan="2" width="15%">No. of working units</th>
								<th style="text-align:center;" rowspan="2" width="15%">No. of unserviceable units</th>
								<th style="text-align:center;" rowspan="2" width="15%">Remarks</th>
								
							</tr>
							<tr>
								<th style="text-align:center;" >DCP Package</th>
								<th style="text-align:center;" >Donated</th>
								<th style="text-align:center;" >Outsourced</th>
							</tr>
							
						</thead>
						<tbody>
						<?php
						$mychs=mysqli_query($con,"SELECT * FROM tbl_chs_status WHERE SchoolID='".$_SESSION['school_id']."'");
						while($rowchs=mysqli_fetch_array($mychs))
						{
							echo '<tr>
								<td style="text-align:center;">'.$rowchs['Hardware_type'].'</td>
								<td style="text-align:center;">'.$rowchs['DCPQTY'].'</td>
								<td style="text-align:center;">'.$rowchs['NonDCPQTY'].'</td>
								<td style="text-align:center;">'.$rowchs['LGUQTY'].'</td>
								<td style="text-align:center;">'.$rowchs['Working_QTY'].'</td>
								<td style="text-align:center;">'.$rowchs['Non_qorkingQTY'].'</td>
								<td style="text-align:center;">'.$rowchs['Remarks'].'</td>
							</tr>';
						}	
						?>
						</tbody>
					   </table>
						</div>
						<div class="tab-pane fade" id="e-class">   
						  <h4 class="page-header">E. E-CLASSROOM / LABORATORY CONDITION</h4>
						   <table width="100%" class="table table-striped table-bordered table-hover">
						    <thead>
								<tr>
									<th style="text-align:center;">INDICATOR</th>
									<th style="text-align:center;">YES</th>
									<th style="text-align:center;">NO</th>
									<th style="text-align:center;">REMARKS</th>
								</tr>
							</thead>
							<tbody>
							    <tr>
									<th colspan="4">SECURITY & SAFETY</th>	
								</tr>
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>Grills are installed to doors and windows and other holes/exits from the classroom.</td>
									<td style="text-align:center;"><input type="radio" name="SS1"></td>	
									<td style="text-align:center;"><input type="radio" name="SS1"></td>	
									<td></td>	
								</tr>
								
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>A security personnel is designated.</td>
									<td style="text-align:center;"><input type="radio" name="SS2"></td>	
									<td style="text-align:center;"><input type="radio" name="SS2"></td>		
									<td></td>	
								</tr>
								
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>Doors are Protected with double padlocks.</td>
									<td style="text-align:center;"><input type="radio" name="SS3"></td>	
									<td style="text-align:center;"><input type="radio" name="SS3"></td>		
									<td></td>	
								</tr>
								
								<tr>
									<th colspan="4">LAB ACTIVITY MONITORING</th>	
								</tr>
								
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>Class schedules are readable and are posted in visible area/s</td>
									<td style="text-align:center;"><input type="radio" name="LAM1"></td>	
									<td style="text-align:center;"><input type="radio" name="LAM1"></td>		
									<td></td>	
								</tr>
								
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>Logbooks are utilized</td>
									<td style="text-align:center;"><input type="radio" name="LAM2"></td>	
									<td style="text-align:center;"><input type="radio" name="LAM2"></td>		
									<td></td>	
								</tr>
								
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>DCPs are available and usable by all Learning Areas</td>
									<td style="text-align:center;"><input type="radio" name="LAM3"></td>	
									<td style="text-align:center;"><input type="radio" name="LAM3"></td>		
									<td></td>	
								</tr>
								
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>User guidelines are readable and are posted in visible area/s</td>
									<td style="text-align:center;"><input type="radio" name="LAM4"></td>	
									<td style="text-align:center;"><input type="radio" name="LAM4"></td>		
									<td></td>	
								</tr>
								
								<tr>
									<th colspan="4">LEARNING ENVIRONMENT</th>	
								</tr>
								
								 <tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>The room is well-ventilated (electric fan air-condition unit are installed)</td>
									<td style="text-align:center;"><input type="radio" name="LE1"></td>	
									<td style="text-align:center;"><input type="radio" name="LE1"></td>		
									<td></td>	
								</tr>
								
								<tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>Walls are free from destructive design.</td>
									<td style="text-align:center;"><input type="radio" name="LE2"></td>	
									<td style="text-align:center;"><input type="radio" name="LE2"></td>		
									<td></td>	
								</tr>
								
								<tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>The computer laboratory is well-lit.</td>
									<td style="text-align:center;"><input type="radio" name="LE3"></td>	
									<td style="text-align:center;"><input type="radio" name="LE3"></td>		
									<td></td>	
								</tr>
								
								<tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>Chairs are sufficient in number (i.e. 50 and above)</td>
									<td style="text-align:center;"><input type="radio" name="LE4"></td>	
									<td style="text-align:center;"><input type="radio" name="LE4"></td>		
									<td></td>	
								</tr>
								
								<tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>Tables are in good condition.</td>
									<td style="text-align:center;"><input type="radio" name="LE5"></td>	
									<td style="text-align:center;"><input type="radio" name="LE5"></td>		
									<td></td>	
								</tr>
								
								<tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>The computer laboratory is clean and orderly.</td>
									<td style="text-align:center;"><input type="radio" name="LE6"></td>	
									<td style="text-align:center;"><input type="radio" name="LE6"></td>		
									<td></td>	
								</tr>
								<tr>
									<td><i class="fa  fa-dot-circle-o fa-fw"></i>The computer laboratory space is suffiient.</td>
									<td style="text-align:center;"><input type="radio" name="LE7"></td>	
									<td style="text-align:center;"><input type="radio" name="LE7"></td>		
									<td></td>	
								</tr>
							</tbody>
							
						   </table>
						  
				  		</div>
				  </div>
				  </div>
						
 
						 <div class="panel-body">
                            
                            <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							
							  <div class="modal fade" id="mybatch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
									<div class="modal-header">
        
										  <h3 class="modal-title"><center>New Batch #</center></h3>
										 
										</div>
										<form action="" method="POST" enctype="multipart/form-data">
										<div class="modal-body">	
										<label>Batch No.</label>
										<select name="batchno" class="form-control" required>
											<option value="">--Select--</option>
										    <?php
											 $listbatch=mysqli_query($con,"SELECT * FROM tbl_batch");
											 while($rowlist=mysqli_fetch_array($listbatch))
											 {
												echo '<option value="'.$rowlist['BatchCode'].'">'.$rowlist['BatchNumber'].'</option>'; 
											 }
											?>
										</select>
										<label>Year Delivered</label>
										<input type="text" name="yeardelivered" placeholder="Year Delivered" class="form-control" required>
										<label>Package Type</label>
										<input type="text" name="packagetype" placeholder="Package Type" class="form-control" required>
										<div class="row"><br/>
										  <div class="col-lg-3">
										  <label>D.R Available?</label>
										     <select name="DR" class="form-control" required>
												<option value="">--Select--</option>
												<option value="YES">YES</option>
												<option value="NO">NO</option>
											 </select>
										  </div>
										  
										  <div class="col-lg-3">
										  <label>I.A.R vailable?</label>
										     <select name="IAR" class="form-control" required>
												<option value="">--Select--</option>
												<option value="YES">YES</option>
												<option value="NO">NO</option>
											 </select>
										  </div>
										  
										 <div class="col-lg-3">
										  <label>I.R.P vailable?</label>
										     <select name="IRP" class="form-control" required>
												<option value="">--Select--</option>
												<option value="YES">YES</option>
												<option value="NO">NO</option>
											 </select>
										  </div>
										  
										  <div class="col-lg-3">
										  <label>P.T.R vailable?</label>
										     <select name="PTR" class="form-control" required>
												<option value="">--Select--</option>
												<option value="YES">YES</option>
												<option value="NO">NO</option>
											 </select>
										  </div>
										  
										</div>
                                    </div>
									<div class="modal-footer">
									 <input type="submit" name="newbatch" id="myBtn" value="Save" class="btn btn-primary">
									<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									</div>
									</form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        <!-- .panel-body -->	

					
                            <!-- Modal -->
							 <div class="panel-body">					
							  <div class="modal fade" id="mynondcp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
									<div class="modal-header">
        
										  <h3 class="modal-title"><center>Non-DCP Package</center></h3>
										 
										</div>
										<form action="" method="POST" enctype="multipart/form-data">
										<div class="modal-body">	
										<label>Hardware Type</label>
										<input type="text" name="hardwaretype" class="form-control" required>
										<label>QTY</label>
										<input type="number" name="qty" class="form-control" required>
										<label>Donated?</label>
										<select name="donated" class="form-control" required>
											<option value="">--select--</option>
											<option value="YES">YES</option>
											<option value="NO">NO</option>
										</select>
										<label>Outsourced?</label>
										<select name="Outsourced" class="form-control" required>
											<option value="">--select--</option>
											<option value="YES">YES</option>
											<option value="NO">NO</option>
										</select>
										<label>Donated by / Outsourced from</label>
										<input type="text" name="donatedby" class="form-control" required>
										</div>
									<div class="modal-footer">
									 <input type="submit" name="newnondcp" id="myBtn" value="Save" class="btn btn-primary">
									<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									</div>
									</form>	
								</div>									
								</div>									
								</div>									
								</div>	


							<!-- Modal -->
							 <div class="panel-body">					
							  <div class="modal fade" id="mychps" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
									<div class="modal-header">
        
										  <h3 class="modal-title"><center>COMPUTER HARDWARE PHYSICAL STATUS</center></h3>
										 
										</div>
										<form action="" method="POST" enctype="multipart/form-data">
										<div class="modal-body">	
										<label>Hardware Type</label>
										<input type="text" name="hardwaretype" class="form-control" required>
										<label>DCP Package</label>
										<input type="number" name="dcpqty" class="form-control" required>
										<label>Donated</label>
										<input type="number" name="donatedqty" class="form-control" required>
										<label>Outsourced</label>
										<input type="number" name="outsourceqty" class="form-control" required>
										<label>No. of Working Units</label>
										<input type="number "name="QTYworking" class="form-control" required>
										<label>No. of Unserviceable Units</label>
										<input type="number "name="QTYnonworking" class="form-control" required>
										<label>Remarks</label>
										<input type="text "name="remarks" class="form-control" required>
										</div>
									<div class="modal-footer">
									 <input type="submit" name="newchsstatus" id="myBtn" value="Save" class="btn btn-primary">
									<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									</div>
									</form>	
								</div>									
								</div>									
								</div>									
								</div>																	