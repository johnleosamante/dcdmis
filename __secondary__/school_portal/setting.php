<?php

$result=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station =tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID='".$_SESSION['uid']."'");
$row_record=mysqli_fetch_assoc($result);

if (isset($_POST['save']))
{
	mysqli_query($con,"UPDATE tbl_employee SET tbl_employee.Emp_TIN='".$_POST['myTIN']."' WHERE tbl_employee.Emp_ID='".$_SESSION['uid']."' LIMIT 1");
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

if (isset($_POST['update']))
	{
		$pass=md5($_POST['password']);	
		if ($_POST['password']<>$_POST['confirm'])
		{
			?>
			<script>
			{
				alert("Password not match!!");
			}
			</script>
			<?php
		}else{
			$pass=md5($_POST['password']);
			mysqli_query($con,"UPDATE tbl_user SET password='".$pass."' WHERE usercode='".$_SESSION['uid']."' LIMIT 1");
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
	}
?>
 <div class="col-lg-12">
  <div class="panel panel-default">
  </div>
 </div>
            <div class="row">
                 <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
							<h4>General Account Settings</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                          <ul class="nav nav-tabs">
                                <li class="active">
									<a href="#erf" data-toggle="tab"> User Information</a>
                                </li>
                                <li>
									<a href="#step" data-toggle="tab"> Security and Login</a>
                                </li>
								
						</ul>
			
							<div class="tab-content">
                                <div class="tab-pane fade in active" id="erf">
								<h3 class="page-header">Account Details</h3>
								<b>
								<table>
								  <?php
									echo '<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Employee ID:</td><td>'.$row_record['Emp_ID'].'</td></tr>
									     <tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Name:</td><td>'.$row_record['Emp_LName'].', '.$row_record['Emp_FName'].' '.$row_record['Emp_MName'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Position:</td><td> '.$row_record['Job_description'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Station:</td><td> '.$row_record['SchoolName'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Address: </td><td>'.$row_record['Emp_Address'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Contact Number:</td><td> '.$row_record['Emp_Cell_No'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> Email Address: </td><td>'.$row_record['Emp_Email'].'</td></tr>
										
										<tr><td style="padding:4px;margin:4px;width:40%;"><i class="fa fa-user  fa-fw"></i> TIN: </td><td>'.$row_record['Emp_TIN'].' <a href="" data-toggle="modal" data-target="#myTIN">Edit</a></td></tr>';
									?>
								</table>
								</b>
								</div>
								 <div class="tab-pane fade" id="step">
								  <div class="col-lg-4">
										<div class="panel panel-default">
										<form action="" Method="POST">
											<div class="panel-heading">
												<h3>Change Password</h3>
											</div>
											<div class="panel-body">
											
											<label>Email:</label>
											<?php
												echo '<input type="email" name="Email" value="'.$row_record['Emp_Email'].'" class="form-control" disabled>';
											?>
											<label>Password:</label>
												<input type="password" name="password" Placeholder="Password" class="form-control">
												<div class="divider"></div>
												<label>Confirm:</label>
												<input type="password" name="confirm" Placeholder="Confirm" class="form-control">
											</div>
											<div class="panel-footer">
													<input type="submit" name="update" value="Change" class="btn btn-primary">
											</div>
											</form>
										</div>
									</div>
								
								</div>
								
								
							</div>
			
			
			  
        </div>
        </div>
        </div>
        </div>
      

<!-- Modal -->
<!-- Modal for Re-assign-->
   <div class="panel-body">

    <!-- Modal -->
      <div class="modal fade" id="myTIN" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
   
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4>Update Tax Indentification Number </h4>
        </div>
        <div class="modal-body">
            <div class="row">
				<form action="" Method="POST" enctype="multipart/form-data">
               
                      <div class="panel-body" >
                       <label>Tax Indentification Number</label>    
						<input type="text" name="myTIN" placeholder="TIN" class="form-control">	
					</div>
				<div class="panel-footer">
				<input type="submit" class="btn btn-primary" name="save" value="SUBMIT">
				 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</form>
				</div>
           
        </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  
  