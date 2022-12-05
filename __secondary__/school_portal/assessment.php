   <div class="col-lg-12">
                    <h2></h2>
                </div>
          <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						
							<h4>BUREAU OF EDUCATION ASSESSMENT - PAGADIAN CITY DIVISION</h4>
							
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php
						$result=mysqli_query($con,"SELECT * FROM tbl_assessment_type_of_exam ORDER BY ExamCode Asc");
						while($row=mysqli_fetch_array($result))
						{
							
						   echo '<div class="col-lg-3 col-md-6">
							<div class="panel panel-'.$row['Examination_color'].'">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa  fa-book  fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">-</div>
											<div>'.$row['Exam_Name'].'</div>
											
										</div>
									</div>
								</div>
								<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code='.urlencode(base64_encode($row['ExamCode'])).'&v='.urlencode(base64_encode("participant")).'">
								<div class="panel-footer">
										<span class="pull-left">View Details</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>';
						}
					?>
				
                </div>
                </div>
                </div>
                           

				