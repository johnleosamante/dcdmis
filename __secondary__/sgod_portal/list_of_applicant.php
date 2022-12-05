<h2 style="padding:4px;margin:14px;">CATEGORY LEVEL</h2>
					
				
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-desktop  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myelement=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='KINDER'");
				
									echo '<div class="huge">'.mysqli_num_rows($myelement).'</div>
                                    <div>KINDER</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("kinder_level")).'">';
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
                                    <i class="fa  fa-desktop  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$myelement=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='ELEMENTARY'");
				
									echo '<div class="huge">'.mysqli_num_rows($myelement).'</div>
                                    <div>ELEMENTARY</div>';
									?>
                                </div>
                            </div>
                        </div>
						<?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("elementary_level")).'">';
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
                                    <i class="fa  fa-desktop  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php
									$mysecondary=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='SECONDARY'");
				
									echo '<div class="huge">'.number_format(mysqli_num_rows($mysecondary),0).'</div>
                                    <div>SECONDARY</div>';
									?>
                                </div>
                            </div>
                        </div>
                       <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("secondary_level")).'">';
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
									$mysenior=mysqli_query($con,"SELECT * FROM tbl_applicant WHERE Category='SENIOR'");
									echo '<div class="huge">'.mysqli_num_rows($mysenior).'</div>
                                    <div>SENIOR HIGH SCHOOL</div>';
									?>
                                </div>
                            </div>
                        </div>
                       <?php
						$str=sha1("Pagadian City Division Data Management Information System");
                        echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("senior_high_level")).'">';
                            ?>
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				