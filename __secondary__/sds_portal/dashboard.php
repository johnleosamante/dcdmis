<?php
date_default_timezone_set("Asia/Manila");
?>
	<h4>Dashboard</h4>
				
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
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_school")).'">';
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
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transaction")).'">';
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
                                    <i class="fa  fa-barcode  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$mydtr=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE Trans_Stats='On Process'");
				
									echo '<div class="huge">'.number_format(mysqli_num_rows($mydtr),0).'</div>
                                    <div>Pending Transaction</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <a href="#mytransaction" data-toggle="modal" class="dropdown-toggle">
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
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_activity")).'">';
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
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("announcement")).'">';
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
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">0</div>
                                    <div>FOR ERF</div>
                                </div>
                            </div>
                        </div>
                       <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("erf")).'">';
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
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("steps")).'">';
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
								$request_Num=mysqli_query($con,"SELECT * FROM tbl_request INNER JOIN tbl_employee ON tbl_request.Emp_ID=tbl_employee.Emp_ID");
					
                                echo '<div class="col-xs-9 text-right">
                                    <div class="huge">'.mysqli_num_rows($request_Num).'</div>
                                    <div>FOR LEAVE</div>
                                </div>';
								?>
                            </div>
                        </div>
                       <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("leaves")).'">';
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
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("transfer")).'">';
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
                                    <i class="fa fa-envelope-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									$mydtr=mysqli_query($con,"SELECT * FROM tbl_dtr WHERE DTRDate='".date("Y-m-d")."'");
				
									echo '<div class="huge">'.mysqli_num_rows($mydtr).'</div>
                                    <div>Daily Time Records</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dtr")).'">';
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
                                    <i class="fa  fa-envelope-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
				
									echo '<div class="huge">-</div>
                                    <div>IPCRF</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("ipcrf")).'">';
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
                                    <i class="fa  fa-taxi fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$loc=mysqli_query($con,"SELECT *FROM tbl_locator_passslip WHERE RequestStatus='For Approval'");
									echo '<div class="huge">'.mysqli_num_rows($loc).'</div>
                                    <div>LOCATORS/PASS SLIP</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("locators")).'">';
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
                                    <i class="fa  fa-taxi fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myvehicle=mysqli_query($con,"SELECT * FROM tbl_vehicle_reservation WHERE RequestStatus='For Approval'");
				
									echo '<div class="huge">'.mysqli_num_rows($myvehicle).'</div>
                                    <div>VEHICLE TRACKING</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("vehicle")).'">';
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
                                    <i class="fa  fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									
									echo '<div class="huge"></div>
                                    <div>PERSONNEL TRACKING</div>';
									?>
                                </div>
                            </div>
                        </div>
                        <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("pts")).'">';
                            ?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				