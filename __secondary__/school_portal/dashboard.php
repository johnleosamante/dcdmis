
 
		<div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Dashboard</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row">
			<div class="col-lg-12">
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
								<?php
								
								$section_Num=mysqli_query($con,"SELECT * FROM tbl_transactions WHERE SchoolID='".$_SESSION['school_id']."'");
                                
								echo '<div class="col-xs-9 text-right">
                                    <div class="huge">'.number_format(mysqli_num_rows($section_Num),0).'</div>
                                   
                                </div>';
								?>
                            </div>
                        </div>
                       <?php
						$str=sha1("Pagadian City Division Data Management Information System");
						echo  '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("Transactions")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Transactions (DTS)</span>
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
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
								<?php
								$register_Num=mysqli_query($con,"SELECT * FROM tbl_registration WHERE SchoolID='".$_SESSION['school_id']."' AND school_year ='".$_SESSION['year']."' AND Sem_Status='Register'");
					
                                echo '
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.number_format(mysqli_num_rows($register_Num),0).'</div>
                                   
                                </div>';
								?>
                            </div>
                        </div>
                       <?php
						
                       echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("registered")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Registered Learner!</span>
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
                                    <i class="fa fa-home fa-5x"></i>
                                </div>
								<?php
								$section_Num=mysqli_query($con,"SELECT * FROM tbl_section WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year='".$_SESSION['year']."'")or die("error data request");
					
                                echo '
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.mysqli_num_rows($section_Num).'</div>
                                   
                                </div>';
								?>
                            </div>
                        </div>
                       <?php
						
                       echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("list_of_section")).'">';
						?> 
                            <div class="panel-footer">
                                <span class="pull-left">School Form 4!</span>
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
                                    <i class="fa fa-desktop fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                             echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("assessment")).'">';
						?>
                            <div class="panel-footer">
                                <span class="pull-left">ASSSESSMENT</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<?php
				if ($_SESSION['Category']=='Secondary')
						{
				echo '<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-desktop fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">';
								
								
								$quali=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school WHERE SchoolID='".$_SESSION['school_id']."' AND QualSem='".$_SESSION['Sem']."'");
							
								  echo  '<div class="huge">'.mysqli_num_rows($quali).'</div>';
                                   
									echo '
                                </div>
                            </div>
                        </div>
                      
						
                             <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("track")).'">
                      
                            <div class="panel-footer">
                                <span class="pull-left">Track/Strand</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
           ';
			}
			?>
			
			 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-home fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("website")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">Website</span>
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
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("school_obligation")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">School Obligations</span>
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
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                     // echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&year='.urlencode(base64_encode($_SESSION['year'])).'&v='.urlencode(base64_encode("school_governance")).'">';
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&year='.urlencode(base64_encode($_SESSION['year'])).'&v='.urlencode(base64_encode("esat")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">IPCRF</span>
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
                                    <i class="fa fa-folder fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("asds_report")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">PPE INVENTORY</span>
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
                                    <i class="fa fa-folder fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("master_program")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">MASTER PROGRAM</span>
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
                                <div class="col-xs-9 text-right">
								<div class="huge">-</div>
									
                                </div>
                            </div>
                        </div>
                      <?php
						
                      echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("Modules")).'">';
                     
						?>
                            <div class="panel-footer">
                                <span class="pull-left">LIST OF MODULE</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
				</div>
				
				
                
				
				
                </div>
		<div class="row">
		
					<div class="col-lg-4">
					
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Enrollment Summary
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-12">
                                     <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        
                                        <th width="25%">School Year</th>
                                        <th width="14%" style="text-align:center;">Male</th>
                                        <th width="14%" style="text-align:center;">Female</th>
                                        <th width="14%" style="text-align:center;">Total</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								   <?php
							      $total=$no=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_school_year");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$malereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");
										$femalereg=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$rowelem['SYCode']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");
										$total=mysqli_num_rows($malereg)+mysqli_num_rows($femalereg);
										$no++;
										echo '<tr>
													
													<td>'.$rowelem['SchoolYear'].'</td>
													<td style="text-align:center;">'.number_format(mysqli_num_rows($malereg),0).'</td>
													<td style="text-align:center;">'.number_format(mysqli_num_rows($femalereg),0).'</td>
													<td style="text-align:center;">'.number_format($total,0).'</td>
													
											  </tr>';
									}
								?>	
								
                                </tbody>
								</table>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                 
                    <!-- /.panel -->
                </div>		
				
                <!-- /.col-lg-12 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Chart for  Quick Count by Grade Level
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
							 <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="25%">Grade Level</th>
                                        <th width="14%" style="text-align:center;">Male</th>
                                        <th width="14%" style="text-align:center;">Female</th>
                                        <th width="14%" style="text-align:center;">Total</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$SecondtotalAll=$SecondtotalAllMale=$SecondtotalAllFemale=$totalAll=$totalAllMale=$totalAllFemale=0;
								
								 if ($_SESSION['Category']=='Elementary')
								 {
									  //Kinder
								$Kinder=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='Kinder' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$maleKinder=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='Kinder'");
								$femaleKinder=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='Kinder'");
										
								echo '<tr>
                                        <td > Kinder</th>
                                        <td style="text-align:center;">'.mysqli_num_rows($maleKinder).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femaleKinder).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($Kinder).'</td>
                                    </tr>';
								 //Grade 1
								$grade1=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='1' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade1=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='1'");
								$femalegrade1=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='1'");
								
								echo '<tr>
                                        <td width="25%">Grade 1</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($malegrade1).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade1).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade1).'</td>
                                       
                                    </tr>';
								 //Grade 2
								$grade2=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='2' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade2=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='2'");
								$femalegrade2=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='2'");
								
								echo '<tr>
                                        <td width="25%">Grade 2</td>
                                       <td style="text-align:center;">'.mysqli_num_rows($malegrade2).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade2).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade2).'</td>
                                       
                                    </tr>';
									 //Grade 3
								$grade3=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='3' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade3=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='3'");
								$femalegrade3=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='3'");
								
								echo '<tr>
                                        <td width="25%">Grade 3</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($malegrade3).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade3).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade3).'</td>
                                       
                                    </tr>';
								//Grade 4
								$grade4=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='4' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade4=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='4'");
								$femalegrade4=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='4'");
								
								echo '<tr>
                                        <td width="25%">Grade 4</td>
                                         <td style="text-align:center;">'.mysqli_num_rows($malegrade4).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade4).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade4).'</td>
                                       
                                    </tr>';
								//Grade 5
								$grade5=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='5' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade5=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='5'");
								$femalegrade5=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='5'");
								
								echo '<tr>
                                        <td width="25%">Grade 5</td>
                                       <td style="text-align:center;">'.mysqli_num_rows($malegrade5).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade5).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade5).'</td>
                                       
                                    </tr>';
								 	
									//Grade 6
								$grade6=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='6' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade6=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='6'");
								$femalegrade6=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='6'");
								
								echo '<tr>
                                        <td width="25%">Grade 6</td>
                                       <td style="text-align:center;">'.mysqli_num_rows($malegrade6).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade6).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade6).'</td>
                                       
                                    </tr>';	
									$totalAllMale=mysqli_num_rows($maleKinder)+mysqli_num_rows($malegrade1)+mysqli_num_rows($malegrade2)+mysqli_num_rows($malegrade3)+mysqli_num_rows($malegrade4)+mysqli_num_rows($malegrade5)+mysqli_num_rows($malegrade6);
									$totalAllFemale=mysqli_num_rows($femaleKinder)+mysqli_num_rows($femalegrade1)+mysqli_num_rows($femalegrade2)+mysqli_num_rows($femalegrade3)+mysqli_num_rows($femalegrade4)+mysqli_num_rows($femalegrade5)+mysqli_num_rows($femalegrade6);
									$totalAll=$totalAllMale+$totalAllFemale;
									echo '<tr>
                                        <td width="25%">Total</td>
                                       <td style="text-align:center;">'.number_format($totalAllMale,0).'</td>
                                        <td style="text-align:center;">'.number_format($totalAllFemale,0).'</td>
                                        <td style="text-align:center;">'.number_format($totalAll,0).'</td>
                                       
                                    </tr>';	
								 }else{
								 //Grade 7
								$grade7=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='7' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade7=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='7'");
								$femalegrade7=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='7'");
										
								echo '<tr>
                                        <td >Grade 7</th>
                                        <td style="text-align:center;">'.mysqli_num_rows($malegrade7).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade7).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade7).'</td>
                                    </tr>';
								 //Grade 8
								$grade8=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='8' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade8=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='8'");
								$femalegrade8=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='8'");
								
								echo '<tr>
                                        <td width="25%">Grade 8</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($malegrade8).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade8).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade8).'</td>
                                       
                                    </tr>';
								 //Grade 9
								$grade9=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='9' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade9=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='9'");
								$femalegrade9=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='9'");
								
								echo '<tr>
                                        <td width="25%">Grade 9</td>
                                       <td style="text-align:center;">'.mysqli_num_rows($malegrade9).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade9).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade9).'</td>
                                       
                                    </tr>';
									 //Grade 10
								$grade10=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='10' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade10=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='10'");
								$femalegrade10=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='10'");
								
								echo '<tr>
                                        <td width="25%">Grade 10</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($malegrade10).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade10).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade10).'</td>
                                       
                                    </tr>';
								//Grade 11
								$grade11=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='11' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade11=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='11'");
								$femalegrade11=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='11'");
								
								echo '<tr>
                                        <td width="25%">Grade 11</td>
                                         <td style="text-align:center;">'.mysqli_num_rows($malegrade11).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade11).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade11).'</td>
                                       
                                    </tr>';
								//Grade 12
								$grade12=mysqli_query($con,"SELECT * FROM tbl_registration WHERE tbl_registration.Grade ='12' AND tbl_registration.school_year='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."'");	 
								$malegrade12=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='MALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='12'");
								$femalegrade12=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn = tbl_student.lrn INNER JOIN tbl_school ON tbl_registration.SchoolID = tbl_school.SchoolID WHERE tbl_student.Gender='FEMALE' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.Grade ='12'");
								
								echo '<tr>
                                        <td width="25%">Grade 12</td>
                                       <td style="text-align:center;">'.mysqli_num_rows($malegrade12).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($femalegrade12).'</td>
                                        <td style="text-align:center;">'.mysqli_num_rows($grade12).'</td>
                                       
                                    </tr>';
									$SecondtotalAllMale=mysqli_num_rows($malegrade7)+mysqli_num_rows($malegrade8)+mysqli_num_rows($malegrade9)+mysqli_num_rows($malegrade10)+mysqli_num_rows($malegrade11)+mysqli_num_rows($malegrade12);
									$SecondtotalAllFemale=mysqli_num_rows($femalegrade7)+mysqli_num_rows($femalegrade8)+mysqli_num_rows($femalegrade9)+mysqli_num_rows($femalegrade10)+mysqli_num_rows($femalegrade11)+mysqli_num_rows($femalegrade12);
									$SecondtotalAll=$SecondtotalAllMale+$SecondtotalAllFemale;
									echo '<tr>
                                        <td width="25%">Total</td>
                                       <td style="text-align:center;">'.number_format($SecondtotalAllMale,0).'</td>
                                        <td style="text-align:center;">'.number_format($SecondtotalAllFemale,0).'</td>
                                        <td style="text-align:center;">'.number_format($SecondtotalAll,0).'</td>
                                       
                                    </tr>';	
								 }
									?>
								</tbody>
								</table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                 </div>
               
			    <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Body Mass Index (B.M.I)
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							<table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
										<th>STATUS</th>
										<th style="text-align:center;">MALE</th>
										<th style="text-align:center;">FEMALE</th>
										<th style="text-align:center;">TOTAL</th>
									</tr>
								</thead>
								<tbody>	
									<tr>
										<td>OBESITY</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
									</tr>
									<tr>
										<td>OVERWEIGHT</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
									</tr>
									<tr>
										<td>UNDERWEIGHT</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
									</tr>
									<tr>
										<td>NORMAL</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
										<td style="text-align:center;">0</td>
									</tr>
								</tbody>
						</table>								
						</div>
						</div>
				</div>
			   
				              
			
							 
				 <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Chart for  List of Personnel by Teacher 1 to 3 position
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
							 <table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Position</th>
                                        <th width="14%" style="text-align:center;">Male</th>
                                        <th width="14%" style="text-align:center;">Female</th>
                                        <th width="14%" style="text-align:center;">Total</th>
                                        <th width="7%" style="text-align:center;"></th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
								 <?php
									$total=$no=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job  WHERE Job_Category='Teacher' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$no++;
										$maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													<td style="text-align:center;"><a href="view_data_personnel.php?id='.urlencode(base64_encode($rowelem['Job_code'])).'" data-toggle="modal" data-target="#viewdata">VIEW</a></td>
											  </tr>';
									}
								?>	
                                </tbody>
								</table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				<div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Chart for  List of Personnel by Master Teacher 1 to 3 position
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
							<table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Position</th>
                                        <th width="14%" style="text-align:center;">Male</th>
                                        <th width="14%" style="text-align:center;">Female</th>
                                        <th width="14%" style="text-align:center;">Total</th>
                                        <th width="7%" style="text-align:center;"></th>
                                    </tr>
                                </thead>
                                <tbody>
								 <?php
									$total=$no=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job  WHERE Job_Category='Master Teacher' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$no++;
										$maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													<td style="text-align:center;"><a href="view_data_personnel.php?id='.urlencode(base64_encode($rowelem['Job_code'])).'" data-toggle="modal" data-target="#viewdata">VIEW</a></td>
											  </tr>';
									}
								?>	
                                </tbody>
								</table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
				
				<div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Chart for  List of Personnel by Head Teacher 1 to 6 position
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
							<table width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Position</th>
                                        <th width="14%" style="text-align:center;">Male</th>
                                        <th width="14%" style="text-align:center;">Female</th>
                                        <th width="14%" style="text-align:center;">Total</th>
                                        <th width="7%" style="text-align:center;"></th>
                                    </tr>
                                </thead>
                                <tbody>
								 <?php
									$total=$no=0;
									$elemen=mysqli_query($con,"SELECT * FROM tbl_job  WHERE Job_Category='Head Teacher' ORDER BY Job_description Asc");
									while($rowelem=mysqli_fetch_array($elemen))
									{
										$no++;
										$maleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Male'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."'");
										$femaleteacher=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID WHERE tbl_employee.Emp_Sex='Female'  AND tbl_station.Emp_Position='".$rowelem['Job_code']."' AND tbl_station.Emp_Station='".$_SESSION['school_id']."'");
										 $total=mysqli_num_rows($maleteacher)+mysqli_num_rows($femaleteacher);
										echo '<tr>
													<td style="text-align:center;">'.$no.'</td>
													<td>'.$rowelem['Job_description'].'</td>
													<td style="text-align:center;">'.mysqli_num_rows($maleteacher).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($femaleteacher).'</td>
													<td style="text-align:center;">'.$total.'</td>
													<td style="text-align:center;"><a href="view_data_personnel.php?id='.urlencode(base64_encode($rowelem['Job_code'])).'" data-toggle="modal" data-target="#viewdata">VIEW</a></td>
											  </tr>';
									}
								?>	
                                </tbody>
								</table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div> 
				 
				
				
				
				
				 
				 
				
				
				
				
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
			
			
			
			
			
			
 <!-- Modal for Re-assign-->
   <div class="panel-body">
                            
                <!-- Modal -->
         <div class="modal fade" id="viewdata" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                   <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>	