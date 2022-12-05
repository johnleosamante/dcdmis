
	<style>
	th{
		text-transform:uppercase;
		text-align:center;
	}
	
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <a href="print-payroll.php?link=6c088cad43cf7aa445bc70a72d24ef4ea66ca048&" target="_blank"class="btn btn-success" style="float:right;"><i class="fa  fa-print  fa-fw"></i>Print Preview</a>
						 <a href="download-payroll.php?link=6c088cad43cf7aa445bc70a72d24ef4ea66ca048&" class="btn btn-primary" style="float:right;"><i class="fa  fa-download  fa-fw"></i>Download</a>
						 	 <?php
							 $_SESSION['code']=$_GET['PayCode'];
							 $mypayroll=mysqli_query($con,"SELECT * FROM tbl_payroll WHERE PayrollCode='".$_GET['PayCode']."' LIMIT 1");
							 $myrow=mysqli_fetch_assoc($mypayroll);
							 echo  '<label>Payroll #:</label>
									<label>'.$_GET['PayCode'].'</label><br/>
									<label>Date & Time Created:</label>
									<label>'.$myrow['PayrollDate'].'</label><br/>
									<label>Payroll Description:</label>
									<label>'.$myrow['PayrollDescription'].'</label><br/>
									<label>Payroll for the Month of :</label>
									<label>'.$myrow['PayrollMonth'].'</label>
									';
							
							
							?>
								
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
							echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th rowspan="2" style="text-align:center;">#</th>
												<th rowspan="2">Employee Name</th>
												<th colspan="4">Deduction</th>
												<th rowspan="2">Gross Pay</th>
												<th rowspan="2">Net Pay</th>
												
												
											</tr>	
											<tr>
												<td style="text-align:center;">GSIS</td>
												<td style="text-align:center;">PAG-IBIG</td>
												<td style="text-align:center;">PHIL-HEALTH</td>
												<td style="text-align:center;">TOTAL</td>
											</tr>
										</thead>
										<tbody>';
										$no=$DedTotal=$NetPay=0;
										$resultpayroll=mysqli_query($con,"SELECT * FROM tbl_payroll_salary INNER JOIN tbl_employee ON tbl_payroll_salary.Emp_ID =tbl_employee.Emp_ID WHERE tbl_payroll_salary.Transaction_code='".$_GET['PayCode']."'ORDER BY tbl_employee.Emp_LName Asc");
										while ($rowpayroll=mysqli_fetch_array($resultpayroll))
											{
												$no++;
												$DedTotal=$rowpayroll['Emp_GSIS']+$rowpayroll['Emp_Pagibig']+$rowpayroll['Emp_Philhealth'];
												$NetPay=$rowpayroll['Gross_income']-$DedTotal;
											 echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td>'.$rowpayroll['Emp_LName'].', '.$rowpayroll['Emp_FName'].'</td>
													<td style="text-align:center;">'.number_format($rowpayroll['Emp_GSIS'],2).'</td>
													<td style="text-align:center;">'.number_format($rowpayroll['Emp_Pagibig'],2).'</td>
													<td style="text-align:center;">'.number_format($rowpayroll['Emp_Philhealth'],2).'</td>
													<td style="text-align:center;">'.number_format($DedTotal,2).'</td>
													<td style="text-align:center;">'.number_format($rowpayroll['Gross_income'],2).'</td>
													<td style="text-align:center;">'.number_format($NetPay,2).'</td>
													</tr>';	
											}
								   echo '</tbody>
										</html>';
							
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
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>New Payroll</center></h3>
		 
        </div>
        <div class="modal-body">
		<?php
		date_default_timezone_set("Asia/Manila");
		$dateposted = date("Y-m-d H:i:s");
		echo '<form action="view-payroll.php?link='.sha1("Pagadian City division Data management system").'" Method="POST" enctype="multipart/form-data">
				<div class="col-lg-6">
							<label>Payroll Code:</label>					       
                            <input type="text"  value="'.date("ydms").'" class="form-control"  disabled>
                            <input type="hidden" name="PayCode" value="'.date("ydms").'" class="form-control"  >
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
						   
							</div>
							 <div class="col-lg-6">
							  <label>Date & Time:</label>					       
                            <input type="text"  value="'.$dateposted.'" class="form-control"  disabled>
                            <input type="hidden" name="dateprocess" value="'.$dateposted.'" class="form-control"  required>
                           
						   <label>Payroll Description:</label>					       
                            <input type="text" name="PayDesc" class="form-control"  required>
                           
                                   
							</div>
							<label>Payroll for:</label>
						<input type="text" name="remark" class="form-control">	<hr/>
				
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