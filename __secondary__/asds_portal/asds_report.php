
                <div class="col-lg-12">
				<?php
				$_SESSION['current_id']=$_GET['code'];
				$myschool=mysqli_query($con,"SELECT * FROM tbl_school WHERE SchoolID='".$_GET['code']."' LIMIT 1");
				$rowschool=mysqli_fetch_assoc($myschool);
                    echo '<h3 class="page-header" style="text-transform:uppercase;">'.$rowschool['SchoolName'].' - '.$_GET['code'].'</h3>';
                ?>
				</div>
       
            <div class="row">
			  <div class="col-lg-12">
                    <h3 class="page-header">PPE INVENTORY</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row">
			  <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
								<div class="col-xs-9 text-right">
								    Semi-expendable property Card
                                                                      
                                </div>
                            </div>
                        </div>
                       <?php
						$str=sha1("Pagadian City Division Data Management Information System");
						echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA1")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.1</span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
								<?php
								
                                echo '
                                <div class="col-xs-9 text-right">
                                    Semi-expendable Ledger Card
                                   
                                </div>';
								?>
                            </div>
                        </div>
                       <?php
						
                       echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA2")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.2</span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
								<?php
								 echo '
                                <div class="col-xs-9 text-right">
                                   Inventory Custodian Slip
                                   
                                </div>';
								?>
                            </div>
                        </div>
                       <?php
						
                       echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA3")).'">';
						?> 
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.3 </span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								Registry of Semi-expendable property Issued
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                             echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA4")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.4 </span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								Inventory Transfer Report
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA5")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.5 </span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								  Receipt of Returned Semi-expendable Property
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA6")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.6</span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								Report of semi-expendable property issued
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA7")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.7 </span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								Report on the Physical Count of Semi-expendable Property
															
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA8")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.8</span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								Report of lost, Stolen, Damaged or Destroyed Semi-expendable Property
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA9")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.9</span>
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
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								Inventory and Inspection Report of unserviceable semi-expendable property
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("AnnexA10")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Annex A.10</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				
				
				
				</div>
				