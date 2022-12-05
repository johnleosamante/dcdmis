
 <div class="row">
                <div class="col-lg-12">
                    <h1 ></h1>
					<?php
					echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($_SESSION['CurrentDistCode'])).'&v='.urlencode(base64_encode("ict_form_report")).'" class="btn btn-secondary" style="float:right;">Back</a>';
					?>
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
			 <?php
			  $myschool=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_employee ON tbl_school.Incharg_ID =tbl_employee.Emp_ID WHERE tbl_school.SchoolID='".$_GET['id']."' LIMIT 1");
			  $rowschool=mysqli_fetch_assoc($myschool);
			  $middleName=mb_strimwidth($rowschool['Emp_MName'],0,1);
			 ?>
			      <div class="col-lg-12">
				  <b> A. BASIC DETAILS</b><hr/>
				   <table width="100%">
				   <tr>
				      <td width="15%">
					    SchoolID:
				     </td>
					  <td>
					   <?php echo $_GET['id']; ?>
				     </td>
					</tr>
					  <tr>
					   <td width="15%">
						SchoolName: 
					   </td>
					   <td>
					      <?php echo  $rowschool['SchoolName']; ?>
					   </td>
					</tr>
					<tr>
					   <td width="15%">
				        School Head:
				       </td>
					   <td>
					   <?php echo  utf8_decode($rowschool['Emp_FName'].' '. $middleName.'. '.$rowschool['Emp_LName']); ?>
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
							
						$batches=mysqli_query($con,"SELECT * FROM tbl_batches WHERE SchoolID='".$_GET['id']."'");
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
								<td width="5%"><a href="" data-toggle="modal" data-target="#viewfiles">VIEW</a></td>
							</tr>';
						}	
						?>
							
						</tbody>
						
					   </table>
					</div>
						
						
						<div class="tab-pane fade" id="non-dcp">   
						  
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
						$nondcp=mysqli_query($con,"SELECT * FROM tbl_non_dcp WHERE SchoolID='".$_GET['id']."'");
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
						$mychs=mysqli_query($con,"SELECT * FROM tbl_chs_status WHERE SchoolID='".$_GET['id']."'");
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
						
 
	<!-- Modal -->
							 <div class="panel-body">					
							  <div class="modal fade" id="viewfiles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
									<div class="modal-header">
        
										  <h3 class="modal-title"><center>List of Attached Documents</center></h3>
										 
										</div>
										
										<div class="modal-body">	
										<iframe src="" width="100%" height="450"></iframe>
										</div>
									<div class="modal-footer">
								
									<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
									</div>
								
								</div>									
								</div>									
								</div>									
								</div>																						