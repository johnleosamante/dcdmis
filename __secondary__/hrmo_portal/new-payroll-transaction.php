
	<style>
	th{
		text-transform:uppercase;
		text-align:center;
	}td{
		text-transform:uppercase;
		
	}
	
	</style>
	<script>
		function addnew(id)
		{
			var a = id;
			$.ajax({
				type:'POST',
				url:'add.php?id='+a,
				data:$('#frmBox').serialize(),
				success:function(response){
				$('#success').html(response);
				}
						
		});

		var form=document.getElementById('frmBox').reset();
		return false;
		}		
	</script>

                 <div class="col-lg-12">
                    <div class="panel panel-default">
					<?php
					echo ' <div class="panel-heading">';
						 	 $data=$_SESSION['code'];
							$encript_1=(($data*123456789*5678)/956783);
											
							  $mypayroll=mysqli_query($con,"SELECT * FROM tbl_payroll WHERE PayrollCode='".$_SESSION['code']."' LIMIT 1");
							 $myrow=mysqli_fetch_assoc($mypayroll);
							 echo  '<a href="" style="float:right;" class="btn btn-success">NEXT</a>
									<label>Payroll #:</label>
									<label>'.$_SESSION['code'].'</label><br/>
									<label>Date & Time Created:</label>
									<label>'.$myrow['PayrollDate'].'</label><br/>
									<label>Payroll Description:</label>
									<label>'.$myrow['PayrollDescription'].'</label><br/>
									<label>Payroll for the Month of :</label>
									<label>'.$myrow['PayrollMonth'].'</label><br/>
									';
							
							echo '<div id="success" class="alert alert-success"></div>';
							?>
								
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						
                            <?php
							echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" >
                            
										<thead>
										
											<tr>
												<th style="text-align:center;width:7%;">#</th>
												<th>Employee Name</th>
												<th>Position</th>
												<th>Contact No.</th>
												<th width="30%">Station</th>
												<th width="7%"></th>
												
											</tr>	
											
										</thead>
										<tbody>';
										
										$no=0;
										$resultpayroll=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID ORDER BY tbl_employee.Emp_LName Asc");
										while ($rowpayroll=mysqli_fetch_array($resultpayroll))
											{
												$no++;
											 echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td>'.$rowpayroll['Emp_LName'].', '.$rowpayroll['Emp_FName'].'</td>
													<td>'.$rowpayroll['Job_description'].'</td>
													<td>'.$rowpayroll['Emp_Cell_No'].'</td>
													<td>'.$rowpayroll['SchoolName'].'</td>
													<td style="text-align:center;">
													<input type="checkbox" title ="per-'.$rowpayroll['Emp_ID'].'" value="'.$rowpayroll['Emp_ID'].'" id="frmBox" name="per-'.$rowpayroll['Emp_ID'].'" style="cursor:pointer;width:20px;height:20px;border-radius:5em;" onclick="addnew(this.value)"></td>
													
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
           
						 