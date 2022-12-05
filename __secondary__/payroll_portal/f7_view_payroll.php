
	<style>
	th,td{
		text-transform:uppercase;
		
	}
	
	</style>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
						 	 <?php
							  $_SESSION['code']=$_GET['PayCode'];
							 echo ' <a href="" style="float:right;" class="btn btn-primary">PRINT PREVIEW</a>';
							 
							 $mypayroll=mysqli_query($con,"SELECT * FROM tbl_payroll WHERE PayrollCode='".$_SESSION['code']."' LIMIT 1");
							 $myrow=mysqli_fetch_assoc($mypayroll);
							 echo  '<label>Payroll #:</label>
									<label>'.$_GET['PayCode'].'</label><br/>
									<label>Date & Time Created:</label>
									<label>'.$myrow['PayrollDate'].'</label><br/>
									<label>Payroll Description:</label>
									<label>'.$myrow['PayrollDescription'].'</label><br/>
									<label>Payroll for the Month of :</label>
									<label>'.$myrow['PayrollMonth'].' '.date('Y').'</label><br/>
									<label>Station :</label>
									<label>'.$myrow['PayrollRemarks'].' '.date('Y').'</label>
									';
							
							
							?>
								
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
							echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th rowspan="2" style="text-align:center;">EmpNo</th>
												<th rowspan="2">Employee Name</th>
												<th rowspan="2">Position Title</th>
												<th rowspan="2"> Basic</th>
												<th rowspan="2">Pera/ACA</th>
												<th colspan="2">Absenses / Undertime</th>
												<th rowspan="2">Cause</th>
												<th rowspan="2">Division Action</th>
												<th rowspan="2">Deductions</th>
												<th rowspan="2">Remarks</th>
												
												
											</tr>	
											<tr>
												<th>Inclusive Date</th>
												<th>Day/hr/Min</th>
											</tr>
										</thead>
										<tbody>';
										$mypayroll=mysqli_query($con,"SELECT * FROM tbl_monhtly_salary_record INNER JOIN tbl_employee ON tbl_monhtly_salary_record.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_f7_salary ON tbl_monhtly_salary_record.Emp_ID = tbl_f7_salary.Emp_ID INNER JOIN tbl_station ON tbl_monhtly_salary_record.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_monhtly_salary_record.PayrollNo='".$_SESSION['code']."'");			
										while($rowpay=mysqli_fetch_array($mypayroll))
										{
										  echo '<tr>
													<td>'.$rowpay['Emp_ID'].'</td>
													<td>'.$rowpay['Emp_LName'].', '.$rowpay['Emp_FName'].'</td>
													<td>'.$rowpay['Job_description'].'</td>
													<td>'.number_format($rowpay['Basic_Salary'],2).'</td>
													<td>'.number_format($rowpay['PERA_ACA'],2).'</td>
													<td>'.$rowpay['Inclusive_date'].'</td>
													<td>'.$rowpay['Number_of_minutes'].'</td>
													<td>'.$rowpay['Couse'].'</td>
													<td>'.$rowpay['Division_action'].'</td>
													<td>'.$rowpay['Deduction'].'</td>
													<td>'.$rowpay['Remarks'].'</td>
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
            
