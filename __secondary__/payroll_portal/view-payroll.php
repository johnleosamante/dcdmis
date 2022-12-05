
	<style>
	th{
		text-transform:uppercase;
		text-align:center;
	}
	
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
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
									<label>'.$myrow['PayrollRemarks'].'</label>
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
												<th rowspan="2"></th>
												
												
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
													<td style="text-align:center;"><a href="" class="btn btn-warning" title="Deduction Information"><i class="fa fa-pencil fa-fw"></i></a></td>
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
            
