<?php
$_SESSION['code']=$_GET['PayCode'];
?>

	<style>
	th{
		text-transform:uppercase;
		text-align:center;
	}
	
	</style>

 <?php
 if (isset($_POST['new_payroll']))
	{
	 mysqli_query($con,"UPDATE tbl_payroll_salary SET tbl_payroll_salary.Emp_GSIS='".$_POST['GSIS']."',tbl_payroll_salary.Emp_Philhealth='".$_POST['Philhealth']."',tbl_payroll_salary.Emp_Pagibig='".$_POST['Pagibig']."',tbl_payroll_salary.Gross_income='".$_POST['GrossPay']."'  WHERE tbl_payroll_salary.Emp_ID ='".$_SESSION['Emp_Code']."' AND tbl_payroll_salary.Transaction_code ='".$_SESSION['code']."' LIMIT 1");
		
	 if(mysqli_affected_rows($con)==1)
			{
			mysqli_query($con,"UPDATE tbl_employee SET Emp_DBP_Account='".$_POST['AccountNumber']."' WHERE Emp_ID='".$_SESSION['Emp_Code']."' LIMIT 1");
	
			$Err="Personnel information successfully saved!";	
			  echo '<script type="text/javascript">
					$(document).ready(function(){						
					$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
							
					});</script>';	
					echo '<div class="alert alert-success">'.$Err.'</div>';
			}
 }
 ?>
            <!-- /.row -->
        
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 	 <?php
							 echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&PayCode='.urlencode(base64_encode($_GET['PayCode'])).'&v='.urlencode(base64_encode("new_payroll")).'" class="btn btn-primary" style="float:right;"><i class="fa  fa-user  fa-fw"></i>Add Personnel</a>';
							 $mypayroll=mysqli_query($con,"SELECT * FROM tbl_payroll WHERE PayrollCode='".$_GET['PayCode']."' LIMIT 1");
							 $myrow=mysqli_fetch_assoc($mypayroll);
							 echo  '<label>Payroll #:</label>
									<label>'.$_SESSION['code'].'</label><br/>
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
												<th rowspan="2" width="5%"></th>
												
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
										$resultpayroll=mysqli_query($con,"SELECT * FROM tbl_payroll_salary INNER JOIN tbl_employee ON tbl_payroll_salary.Emp_ID =tbl_employee.Emp_ID WHERE tbl_payroll_salary.Transaction_code='".$_SESSION['code']."'ORDER BY tbl_employee.Emp_LName Asc");
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
													<td style="text-align:center;"><a href="update-data.php?id='.$rowpayroll['Emp_ID'].'" data-toggle="modal" data-target="#Mylog"><i class="fa fa-desktop fa-fw"></i></a></td>
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
            
	<script>
	 function Enable_all(str)
	 {
	     
	    if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("txtview").innerHTML=xmlhttp.responseText;
			}
		  }
		  xmlhttp.open("GET","teacher-info.php?id="+str,false);
		  xmlhttp.send();
	 
		document.getElementById("dbpaccount").disabled=false;
		document.getElementById("GSIS").disabled=false;
		document.getElementById("Pagibig").disabled=false;
		document.getElementById("Philhealth").disabled=false;
		document.getElementById("GrossPay").disabled=false;
		document.getElementById("GSIS").focus();
	 
	 }
	 function newaccount()
	 {
		 var a = document.getElementById("dbpaccount").value ;
		document.getElementById("newpaccount").value=a; 
	 }	 
	</script>
	



						 
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