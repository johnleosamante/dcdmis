<script type="text/javascript">
		$(document).ready(function(){						
			setInterval(function(){
				$("#loadlogs").load("systemlogs.php")
							
				},100);
							
		});
	</script>
	<a href="#viewlogs" class="btn btn-primary" style="float:right;" data-toggle="modal">VIEW LOGS</a>
<h2>Dashboard</h2>

		<div class="row">						
			<div class="col-lg-12">	
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-home  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myschool=mysqli_query($con,"SELECT * FROM tbl_school WHERE tbl_school.SchoolID <>'123131'");
				
									echo '<div class="huge">'.mysqli_num_rows($myschool).'</div>
                                    <div>LIST OF SCHOOLS</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_school")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				
				
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-taxi  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$mytrans=mysqli_query($con,"SELECT * FROM tbl_transactions_log WHERE Forwarded_to='".$_SESSION['station']."' AND Status='New' ORDER BY Date_recieved Desc");
				
									echo '<div class="huge">'.mysqli_num_rows($mytrans).'</div>
                                    <div>TRANSACTION</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transaction")).'">';
                            
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-desktop  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$mytrain=mysqli_query($con,"SELECT * FROM tbl_school_query  ORDER BY TicketNo Desc");
				
									echo '<div class="huge">'.mysqli_num_rows($mytrain).'</div>
                                    <div>HelpDesk</div>';
									?>
                                </div>
                            </div>
                        </div>
                       <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("HelpDesk")).'">';
                            
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-user  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myschool=mysqli_query($con,"SELECT * FROM tbl_employee WHERE tbl_employee.Emp_Status ='Registered'");
				
									echo '<div class="huge">'.mysqli_num_rows($myschool).'</div>
                                    <div>NEW REGISTERED</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("registered")).'">';
                            
						?>
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa   fa-envelope-o  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <div class="huge">-</div>
                                    <div>Upload LM's</div>
									
                                </div>
                            </div>
                        </div>
						<?php
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("lmupload")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				<!-- Add New Downloadable -->
             <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                  <i class="fa fa-user fa-5x"></i>
                                </div>
								<?php
								$no_of_files=mysqli_query($con,"SELECT * FROM tbl_dtr WHERE DTRDate ='".date("Y-m-d")."'");	
							   echo '<div class="col-xs-9 text-right">
                                    <div class="huge">'.mysqli_num_rows($no_of_files).'</div>
                                    <div>List of DTR</div>
                                </div>';
                               ?> 
                            </div>
                        </div>
						  <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("view_dtr")).'">';
                            
						?>
                      
                            <div class="panel-footer">
                                <span class="pull-left">Manage</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div> 
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa   fa-users  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									echo '<div class="huge">-</div>
                                    <div>ASSESSMENT</div>
									
                                </div>
                            </div>
                        </div>
                        <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dbea")).'">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>';
				
				?>
				
							
			<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa   fa-envelope-o  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									echo '<div class="huge">-</div>
                                    <div>IPCRF CONSOL</div>';
									?>
                                </div>
                            </div>
                        </div>
                         <?php
                      // echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("pisa_exam")).'">';
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("ipcrf")).'">';
                            
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa   fa-upload  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									echo '<div class="huge">-</div>
                                    <div>CLOUD BACKUP</div>';
									?>
                                </div>
                            </div>
                        </div>
                         <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("cloud_storage")).'">';
                            
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa   fa-upload  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$resetme=mysqli_query($con,"SELECT * FROM tbl_deped_reset_account WHERE Remarks='For reset'");
									echo '<div class="huge">'.mysqli_num_rows($resetme).'</div>
                                    <div>DEPED ACCOUNT</div>';
									?>
                                </div>
                            </div>
                        </div>
                         <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("account_reset")).'">';
                            
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
	
			<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa   fa-credit-card  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									echo '<div class="huge">-</div>
                                    <div>ID MAKER</div>';
									?>
                                </div>
                            </div>
                        </div>
                         <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("idmaker")).'">';
                            
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa   fa-credit-card  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									echo '<div class="huge">-</div>
                                    <div>CERTIFICATE</div>';
									?>
                                </div>
                            </div>
                        </div>
                         <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("certificate_maker")).'">';
                            
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-folder  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									echo '<div class="huge">-</div>
                                    <div>PPE INVENTORY</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                        echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("asds_school")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				
        </div>
		
		
      </div>
	 	        <!-- Modal -->
	 <div class="modal fade" id="viewlogs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">SYSTEM USER LOGS AS OF <?php echo date("F d, Y"); ?></h4>
			</div>
			 
			<div class="modal-body">
			 <table width="100%" class="table table-striped table-bordered table-hover">
                <thead>
					<tr>
						<th>IP</th>
						<th>NAME</th>
						<th>Date and Time</th>
						<th>Navigation</th>
					</tr>
                </thead>
				<tbody>
				<?php
				$result=mysqli_query($con,"SELECT * FROM tbl_system_logs INNER JOIN tbl_employee ON tbl_system_logs.Emp_ID = tbl_employee.Emp_ID WHERE tbl_system_logs.Time_Log LIKE '".date("Y-m-d")."%' ORDER BY tbl_system_logs.Time_Log Desc");
				while($rowre=mysqli_fetch_array($result))
				{
					echo '<tr>
							<td>'.$rowre['IPAddress'].'</td>
							<td>'.$rowre['Emp_LName'].', '.$rowre['Emp_FName'].'</td>
							<td>'.$rowre['Time_Log'].'</td>
							<td>'.$rowre['Status'].'</td>
						</tr>';
				}
				?>
				</tbody>
				</table>
		   	</div>
           <div class="modal-footer">
		   <a href="" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>
 
