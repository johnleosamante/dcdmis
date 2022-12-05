
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						  <a href="#newsalary" class="btn btn-primary" style="float:right;" data-toggle="modal">New Payroll</a>
							<h4>Monthly Payroll Worksheet & Report of Service History</h4>
							<?php
							date_default_timezone_set("Asia/Manila");
							$dateposted = date("Y-m-d H:i:s");
							if (isset($_POST['new_payroll']))
							{
							  $description="Monthly Payroll Worksheet & Report of Service for the Month of ".$_POST['Month'].' '. date("Y");	
							  mysqli_query($con,"INSERT INTO tbl_payroll VALUES('".$_POST['PayCode']."','".$_POST['dateprocess']."','".$description."','".$_POST['Month']."','Encoding','".$_POST['remark']."','".$_SESSION['uid']."','REGULAR')");
							  $requery=mysqli_query($con,"SELECT * FROM tbl_f7_salary WHERE CodeNo='".$_POST['stationcode']."'");
							  while($rowquery=mysqli_fetch_array($requery))
							  {
								mysqli_query($con,"INSERT INTO tbl_monhtly_salary_record VALUES(NULL,'','','','','','','".$rowquery['Emp_ID']."','".$_POST['stationcode']."','".$_POST['PayCode']."')");
							  }

							 if (mysqli_affected_rows($con)==1)
								{
									
								?>
								<script type="text/javascript">
									$(document).ready(function(){						
										 $('#addrecord').modal({
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
										$mypayroll=mysqli_query($con,"SELECt * FROM tbl_payroll INNER JOIN tbl_employee ON tbl_payroll.CreatedBy = tbl_employee.Emp_ID INNER JOIN tbl_salary_station ON tbl_payroll.PayrollRemarks = tbl_salary_station.CodeNo WHERE tbl_payroll.PayStatus='REGULAR'");
										while($payrow=mysqli_fetch_array($mypayroll))
										{
											$no++;
											echo '<tr>
													<td>'.$no.'</td>
													
													<td>'.$payrow['PayrollDescription'].'</td>
													<td>'.$payrow['PayrollDate'].'</td>
													<td>'.$payrow['Emp_LName'].', '.$payrow['Emp_FName'].'</td>
													<td>'.$payrow['PayrollRemarks'].' - '.$payrow['Station'].'</td>
													<td>'.$payrow['PayrollStatus'].'</td>
													<td style="text-align:center;"><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&PayCode='.urlencode(base64_encode($payrow['PayrollCode'])).'&v='.urlencode(base64_encode("f7_view_payroll")).'" title="View Payroll"><i class="fa  fa-desktop  fa-fw"></i></a></td>
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
     <div class="modal fade" id="newsalary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Payroll</center></h3>
		 
        </div>
        <div class="modal-body">
		<?php
		date_default_timezone_set("Asia/Manila");
		$dateposted = date("Y-m-d H:i:s");
		echo '<form action="" Method="POST" enctype="multipart/form-data">
	                        <input type="hidden" name="PayCode" value="'.date("ydms").'" class="form-control"  >
							
							  <label>Date & Time:</label>					       
                            <input type="text"  value="'.$dateposted.'" class="form-control"  disabled>
                            <input type="hidden" name="dateprocess" value="'.$dateposted.'" class="form-control"  required>
                           	<label>Payroll for:</label>
						<select name="stationcode" class="form-control" required>
						<option value="">--Select--</option>';
							$payfor=mysqli_query($con,"SELECT * FROM tbl_salary_station ORDER BY Station Asc");
							while($rowpay=mysqli_fetch_array($payfor))
							{
							 echo '<option value="'.$rowpay['CodeNo'].'">'.$rowpay['Station'].'</option>';	
							}
				
				   echo '</select>
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
						   
						 
                                   
							<hr/>
				
				<input type="submit" name="new_payroll" value="Create" class="btn btn-primary">
			
        </form>';
		?>
		</div>
		

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
						
						
						
						
	
				
				
				 <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                 <!-- Modal -->
     <div class="modal fade" id="addrecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
     <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Successfully Save!</center></h3>
		 
        </div>
        <div class="modal-body">

              <center>
			<img src="../logo/check.png" width="100%" height="30%">
			
			 <?php
		  
			echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("monthly_salary")).'" class="btn btn-success"> NEXT</a>';
		   
		   ?>
		   </center>
		   	</div>
           

	</div></div>
	</div>
	</div>
 	  