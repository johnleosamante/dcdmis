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
				
									echo '<div class="huge">'.mysqli_num_rows($mytrans).'</div>
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
				
							
   <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="viewattach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	

	</div></div>
</div>
  </div>
 
