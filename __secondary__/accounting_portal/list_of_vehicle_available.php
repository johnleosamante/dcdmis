<?php
session_start();
include("../pcdmis/vendor/jquery/function.php");
$_SESSION['daterequest']=$_GET['id'];
?>
<h2 style="text-transform:uppercase;">List of Vehicle Available</h2>
				<div class="row">
			<?php
			      $result=mysqli_query($con,"SELECT * FROM tbl_vehicle");
						while($row=mysqli_fetch_array($result))
						{
							if (mysqli_num_rows($result)==1)
							{
							   echo '<div class="col-lg-12 col-md-6">
								<div class="panel panel-'.$row['VColor'].'">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa   fa-car  fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">-</div>
												<div>'.$row['Vehicle_Description'].'</div>
											</div>
										</div>
									</div>';
								 
									$str=sha1("Pagadian City Division Data Management Information System");
									echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&vcode='.urlencode(base64_encode($row['VehicleCode'])).'&v='.urlencode(base64_encode("vehicle_request_form")).'">
										<div class="panel-footer">
											<span class="pull-left">Continue</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>';
							}elseif (mysqli_num_rows($result)==2)
							{
								 echo '<div class="col-lg-6 col-md-6">
								<div class="panel panel-'.$row['VColor'].'">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa   fa-car  fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">-</div>
												<div>'.$row['Vehicle_Description'].'</div>
											</div>
										</div>
									</div>';
								 
									$str=sha1("Pagadian City Division Data Management Information System");
									echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&vcode='.urlencode(base64_encode($row['VehicleCode'])).'&v='.urlencode(base64_encode("vehicle_request_form")).'">
										<div class="panel-footer">
											<span class="pull-left">Continue</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>';
							}else{
								 echo '<div class="col-lg-4 col-md-6">
								<div class="panel panel-'.$row['VColor'].'">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa   fa-car  fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">-</div>
												<div>'.$row['Vehicle_Description'].'</div>
											</div>
										</div>
									</div>';
								 
									$str=sha1("Pagadian City Division Data Management Information System");
									echo '<a href="./?7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&vcode='.urlencode(base64_encode($row['VehicleCode'])).'&v='.urlencode(base64_encode("vehicle_request_form")).'">
										<div class="panel-footer">
											<span class="pull-left">Continue</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>';
							}
						}
						?>
					</div>	