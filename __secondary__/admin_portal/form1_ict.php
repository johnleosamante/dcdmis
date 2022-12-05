
	<style>
	th{
		text-transform:uppercase;
	}
	</style>

                 <div class="col-lg-12">
				   <div class="panel panel-default">
				  <div class="panel-heading">
				 
						 	<h4> School ICT Monitoring Reports by District</h4>
                        </div>
                    <div class="panel-body">  
				<?php
				$result=mysqli_query($con,"SELECT * FROM tbl_district WHERE District_code <> 'D-115' ORDER BY District_code Asc");
				while($row=mysqli_fetch_array($result))
				{
					$list=mysqli_query($con,"SELECT * FROM tbl_school WHERE District_code='".$row['District_code']."'");
                   echo '<div class="col-lg-3 col-md-6">
                    <div class="panel panel-'.$row['Colorbox'].'">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-home  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.mysqli_num_rows($list).'</div>
                                    <div>'.$row['District_Name'].'</div>
                                </div>
                            </div>
                        </div>
						<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&code='.urlencode(base64_encode($row['District_code'])).'&v='.urlencode(base64_encode("ict_form_report")).'">
						<div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				';
				}
						?>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>
                