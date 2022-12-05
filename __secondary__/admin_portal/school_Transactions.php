		 
		 	<script type="text/javascript">
							$(document).ready(function(){						
							setInterval(function(){
								$("#data-refresh").load("transaction-flow.php")
							},1000);
							
							});</script>
							
				
						
						
			<script type="text/javascript">
				function formSubmit(){
					$.ajax({
						type:'POST',
						url:'insert.php',
						data:$('#frmBox').serialize(),
						success:function(response){
							$('#success').html(response);
						}
						
					});

				var form=document.getElementById('frmBox').reset();
				document.getElementById('section').setFucos;
				return false;
				}
				</script>	
 
		
			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div> 				
	            <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
						 echo'<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&c='.urlencode(base64_encode($_SESSION['SchoolID'])).'&v='.urlencode(base64_encode("view_school")).'" class="btn btn-secondary" style="float:right;">Back</a>';
                       
						  $record=mysqli_query($con,"SELECT * FROM tbl_school INNER JOIN tbl_district ON tbl_school.District_code = tbl_district.District_code WHERE SchoolID ='".$_SESSION['SchoolID']."'  ORDER BY SchoolName Asc") or die ("Profile School Error");
							  $row=mysqli_fetch_assoc($record);
							  echo '<h3 class="media-heading" style="padding:4px;margin:4px;"><i class="fa  fa-map-marker  fa-fw"></i>'.$row['SchoolName'].'- School ID:'. $_SESSION['SchoolID'].' ('.$row['District_Name'].')</h3> <p> 
									  <small class="text-muted" style="padding:4px;margin:4px;">'.$row['Address'].' </small>
									</p>';
						 ?>
							<h4 style="float:right;" class="btn btn-info">Transactions History</h4>
							<table style="padding:4px;margin:10px;">
						<?php
							$repre=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID ='".$_SESSION['EmpID']."'") or die("Table not found!!!");
							$data=mysqli_fetch_assoc($repre);
							if ($data['Picture']<>NULL)
							 {
								echo  '<img src="../../../pcdmis/images/'.$data['Picture'].'" style="width:150px;height:150px;padding:4px;margin:4px;" align="left">';
							 }else{
								 echo  '<img src="../../pcdmis/logo/user.png" style="width:150px;height:150px;padding:4px;margin:4px;" align="left">';
							 
							 }
							echo '<tr style="text-transform:uppercase;"><td>Employee ID #:</td><td style="color:blue;padding:4px;margin:4px;">'.$_SESSION['EmpID'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Name: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_LName'].', '.$data['Emp_FName'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Sex: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Sex'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Position: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Job_description'].'</font></td></tr>
							<tr style="text-transform:uppercase;"><td>Contact No.: </td><td style="color:blue;padding:4px;margin:4px;">'.$data['Emp_Cell_No'].'</font></td></tr>';
					
						?>
								</table> 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							
                            <?php
							$tot=$totm=$totf=0;
							
								echo '<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
										<thead>
										
											<tr>
												<th style="width:5%;text-align:center;">#</th>
												
												<th style="width:30%;">Description</th>
												<th style="text-align:center;width:15%;">Date Time Created</th>
												<th style="text-align:center;width:10%;">Status</th>
												<th style="text-align:center;width:5%;"></th>
												
											</tr>	
											
										</thead>
										<tbody>';
										$no=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE tbl_transactions.SchoolID='".$_SESSION['SchoolID']."' ORDER BY tbl_transactions.TransCode Desc");
											while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											echo '<tr>
													<td style="text-align:center;">'.$no.'</td>';
													
													
													echo '<td>'.$row['Title'].'</td>';
													echo '
													<td style="text-align:center;">'.$row['Date_time'].'</td>
													<td style="text-align:center;">'.$row['Trans_Stats'].'</td>
													<td style="text-align:center;"><a href="view_transaction_history.php?code='.urlencode(base64_encode($row['TransCode'])).'" data-toggle="modal" data-target="#viewhistory"class="btn btn-primary" style="padding:4px;margin:4px;">VIEW</a></td>
													
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
  <div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="viewhistory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div style="width:75%;margin-top:10px;margin-left:auto;margin-right:auto;">
    
      <!-- Modal content-->
      <div class="modal-content">
	  
	</div>
	</div>
</div>
  </div>