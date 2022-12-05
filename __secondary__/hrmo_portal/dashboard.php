<h2>Dashboard</h2>

				
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
				
									echo '<div class="huge">'.number_format(mysqli_num_rows($mytrans),0).'</div>
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
									$mytrain=mysqli_query($con,"SELECT * FROM tbl_seminar WHERE Office='".$_SESSION['station']."' ORDER BY Training_Code Desc");
				
									echo '<div class="huge">'.mysqli_num_rows($mytrain).'</div>
                                    <div>ACTIVITY</div>';
									?>
                                </div>
                            </div>
                        </div>
                          <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("activity")).'">';
                            
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
                                    <i class="fa   fa-envelope-o  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$mytrain=mysqli_query($con,"SELECT * FROM post WHERE post_office='".$_SESSION['station']."' ORDER BY date_posted Desc");
				
									echo '<div class="huge">'.mysqli_num_rows($mytrain).'</div>
                                    <div>POST</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("announcement")).'">';
                            
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
                                    <i class="fa fa-truck fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myerf=mysqli_query($con,"SELECT * FROM tbl_online_application WHERE Transaction_office='HRMO'");
                                    echo '<div class="huge">'.mysqli_num_rows($myerf).'</div>';
                                  ?>  
                                    <div>FOR ERF</div>
                                </div>
                            </div>
                        </div>
                      <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("erf")).'">';
                            
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
                                    <i class="fa fa-signal fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<?php
									$myStep=mysqli_query($con,"SELECT * FROM tbl_step_increment WHERE tbl_step_increment.No_of_year >=3");
                                    echo '<div class="huge">'.mysqli_num_rows($myStep).'</div>';
                                  ?>  
									<div>FOR STEPS </div>
                                </div>
                            </div>
                        </div>
                         <?php
                       echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("steps")).'">';
                            
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
                                    <i class="fa fa-folder fa-5x"></i>
                                </div>
								<?php
								$request_Num=mysqli_Query($con,"SELECT * FROM tbl_request INNER JOIN tbl_employee ON tbl_request.Emp_ID=tbl_employee.Emp_ID")or die("error data request");
					
                                echo '<div class="col-xs-9 text-right">
                                    <div class="huge">'.mysqli_num_rows($request_Num).'</div>
                                    <div>FOR LEAVE</div>
                                </div>';
								?>
                            </div>
                        </div>
                        <a href="#myRequest" data-toggle="modal" class="dropdown-toggle">
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
                                    <i class="fa fa-male fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<?php
								$myRetired=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID WHERE tbl_station.Emp_age >='60' AND tbl_employee.Emp_Status <>'Retired'")or die("Error Retirees data");
								$myret=mysqli_num_rows($myRetired);		
								   echo '<div class="huge">'.$myret.'</div>
                                    <div>FOR RETIRABLE</div>';
                                
								?>
								</div>
                            </div>
                        </div>
                        <a href="#myRetiree" data-toggle="modal" class="dropdown-toggle">
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
                                    <i class="fa  fa-taxi  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$mytrans=mysqli_query($con,"SELECT * FROM tbl_transfer_data")or die("Error transfer data");
				
									echo '<div class="huge">'.mysqli_num_rows($mytrans).'</div>
                                    <div>FOR TRANSFER</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                        echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("request_for_transfer")).'">';
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
                                    <i class="fa  fa-taxi  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myvts=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation WHERE Office='".$_SESSION['station']."'");
				
									echo '<div class="huge">'.mysqli_num_rows($myvts).'</div>
                                    <div>VEHICLE REQUEST</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                        echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("request_for_vehicle")).'">';
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
                                    <i class="fa  fa-users  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									echo '<div class="huge">-</div>
                                    <div>201 FILES</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
                        echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("personnel_201_file")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>