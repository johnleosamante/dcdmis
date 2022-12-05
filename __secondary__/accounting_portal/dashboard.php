<h2>Dashboard</h2>
				
				
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
                                    <i class="fa   fa-database  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
													
									echo '<div class="huge">-</div>
                                    <div>PFD</div>';
									?>
                                </div>
                            </div>
                        </div>
                      <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("provident")).'">';
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
                </div>
				
				<hr/>
				<div class="row">
				 <div class="col-lg-12">
				<h3>TRANSACTION HISTORY</h3>
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            
				<thead>
										
					<tr>
						<th style="text-align:center;width:5%;">#</th>
						<th width="15%">Transaction Code</th>
						<th width="15%">Date Time Released</th>
						<th>Transaction Information</th>
						<th style="text-align:center;" width="15%">From Office</th>
						<th style="text-align:center;" width="15%">Transmitted to</th>
						<th style="text-align:center;" width="15%">Status</th>
							
					</tr>						
				 </thead>
				 <tbody>
				 <?php
				 $no=0;
				 $result=mysqli_query($con,"SELECT * FROM tbl_transactions_log INNER JOIN tbl_transactions ON tbl_transactions_log.Transaction_code=tbl_transactions.TransCode WHERE tbl_transactions_log.Forwarded_to='".$_SESSION['station']."' OR tbl_transactions_log.From_office='".$_SESSION['station']."' ORDER BY tbl_transactions_log.Date_recieved Desc LIMIT 300");
				 while($row=mysqli_fetch_array($result))
				 {
					 $no++;
					 echo '<tr>
							<td>'.$no.'</td>
							<td>'.$row['Transaction_code'].'</td>
							<td>'.$row['Date_recieved'].'</td>
							<td>'.$row['Title'].'</td>
							<td>'.$row['From_office'].'</td>
							<td>'.$row['Forwarded_to'].'</td>
							<td>'.$row['Trans_status'].'</td>
						  </tr>';
				 }
				 ?>
			     </tbody>
			</table>
			</div>
			</div>