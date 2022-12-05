
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <a href="#newtrack" class="btn btn-primary" style="float:right;" data-toggle="modal">New Payroll</a>
							<h4>Payroll History</h4>
							<?php
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							if (isset($_POST['new_payroll']))
							{
							  mysqli_query($con,"INSERT INTO tbl_payroll VALUES('".$_POST['PayCode']."','".$_POST['dateprocess']."','".$_POST['PayDesc']."','".$_POST['Month']."','Encoding','".$_POST['remark']."','".$_SESSION['uid']."','SUPPLEMENTARY')");
								if (mysqli_affected_rows($con)==1)
								{
								$salary=mysqli_query($con,"SELECT * FROM tbl_f7_salary WHERE CodeNo='520'");	
								$gross=0;
								while($rowsal=mysqli_fetch_array($salary))
								{
									$gross=$rowsal['Basic_Salary']+$rowsal['PERA_ACA'];
									mysqli_query($con,"INSERT INTO tbl_payroll_salary VALUES (NULL,'".$rowsal['Emp_ID']."','','','','".$gross."','".$_POST['PayCode']."')");
								}
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
                            <?php
							$tot=$totm=$totf=0;
							
								echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="text-align:center;">#</th>
												
												<th>Payroll Discription</th>
												<th style="text-align:center;" width="15%">Date Time Created</th>
												<th style="text-align:center;" width="15%">Process by</th>
												<th style="text-align:center;" width="15%">Payroll for</th>
												<th style="text-align:center;" width="15%">Status</th>
												<th width="7%"></th>
											</tr>	
											
										</thead>
										<tbody>';
										$no=0;
										$mypayroll=mysqli_query($con,"SELECt * FROM tbl_payroll INNER JOIN tbl_employee ON tbl_payroll.CreatedBy = tbl_employee.Emp_ID WHERE tbl_payroll.PayStatus <> 'REGULAR'");
										while($payrow=mysqli_fetch_array($mypayroll))
										{
											$no++;
											echo '<tr>
													<td>'.$no.'</td>
													
													<td>'.$payrow['PayrollDescription'].'</td>
													<td>'.$payrow['PayrollDate'].'</td>
													<td>'.$payrow['Emp_LName'].', '.$payrow['Emp_FName'].'</td>
													<td>'.$payrow['PayrollRemarks'].'</td>
													<td>'.$payrow['PayrollStatus'].'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&PayCode='.urlencode(base64_encode($payrow['PayrollCode'])).'&v='.urlencode(base64_encode("view_payroll")).'" title="View Payroll"><i class="fa  fa-desktop  fa-fw"></i></a></td>
												</tr>';
										}
										
										echo '</tbody>
									</table>';
						
							
							
							?>
                                                         
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           


   <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="newtrack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
        
          <h3 class="modal-title"><center>New Payroll</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		date_default_timezone_set("Asia/Manila");
		$dateposted = date("Y-m-d H:i:s");
		echo '
	                        <input type="hidden" name="PayCode" value="'.date("ydms").'" class="form-control"  >
							
							  <label>Date & Time:</label>					       
                            <input type="text"  value="'.$dateposted.'" class="form-control"  disabled>
                            <input type="hidden" name="dateprocess" value="'.$dateposted.'" class="form-control"  required>
                           
						   <label>Month:</label>					       
                            <select name="Month" class="form-control"  required>
								<option value="">--select--</option>
								<option value="January">January</option>
								<option value="February">February</option>
								<option value="March">March</option>
								<option value="April">April</option>
								<option value="May">May</option>
								<option value="June">June</option>
								<option value="July">July</option>
								<option value="August">August</option>
								<option value="September">September</option>
								<option value="October">October</option>
								<option value="November">November</option>
								<option value="December">December</option>
							</select>
						   
						   <label>Payroll Description:</label>					       
                            <textarea name="PayDesc" class="form-control"  required ></textarea>
                           
                                   
							<label>Payroll for:</label>
						<textarea name="remark" class="form-control" required></textarea>	
				
				
			
      ';
		?>
		</div>
		  <div class="modal-footer">
		  <input type="submit" name="new_payroll" value="Create" class="btn btn-primary">
		<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		  </div>
		  </form>

		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->



						 
						 <div class="panel-body">
                            
                            <!-- Modal -->
							 <div class="panel-body">
                            
                 <!-- Modal -->
							 <div class="modal fade" id="Mylog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							 <div class="modal-dialog">
    
                                    <div class="modal-content">
										
										
										
										
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                        </div>
                        <!-- .panel-body -->