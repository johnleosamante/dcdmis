
		
		<div class="col-lg-12">
			    <div class="panel panel-default">
                    <div class="panel-heading">
					<?php
					   echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("search_data")).'" class="btn btn-primary" style="float:right;">Add Learner</a>';
					?>	
					<p>Class Advisory Learner's Masterlist</p>	
							<?php
							 echo 'Grade '.$_SESSION['Grade_Level'].' - '.$_SESSION['SecName'];
							?>
					  </div>
					  <div class="panel-body">
					  <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                      
                                        <th width="7%">LRN</th>
                                        <th width="10%">Last Name</th>
                                        <th width="15%">First Name</th>
                                        <th width="10%">Middle Name</th>
                                        <th width="6%">Sex</th>
                                        <th width="10%">Birthdate</th>
                                        <th width="25%">Last School Attended</th>
                                        
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
							if ($_SESSION['Grade_Level']=='11' || $_SESSION['Grade_Level']=='12')
							{
								if ($_SESSION['Sem']=='First Semester')
								{
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn INNER JOIN tbl_school ON first_semester.SchoolID = tbl_school.SchoolID WHERE first_semester.school_year='".$_SESSION['year']."' AND first_semester.SecCode='".$_SESSION['CurrentCode']."' AND first_semester.Grade='".$_SESSION['Grade_Level']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn ORDER BY Lname Asc");
									
								}elseif ($_SESSION['Sem']=='Second Semester')
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn INNER JOIN tbl_school ON second_semester.SchoolID = tbl_school.SchoolID WHERE second_semester.school_year='".$_SESSION['year']."' AND second_semester.SecCode='".$_SESSION['CurrentCode']."' AND second_semester.Grade='".$_SESSION['Grade_Level']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn ORDER BY Lname Asc");
								}
							}else{
								$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn INNER JOIN tbl_school ON tbl_learners.SchoolID = tbl_school.SchoolID INNER JOIN tbl_registration ON tbl_learners.lrn=tbl_registration.lrn WHERE tbl_learners.school_year='".$_SESSION['year']."' AND tbl_learners.SecCode='".$_SESSION['CurrentCode']."' AND tbl_registration.Grade='".$_SESSION['Grade_Level']."' AND tbl_learners.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn ORDER BY Lname Asc");

							}	
								
								
									while($row=mysqli_fetch_array($myinfo))
									{
										
                                      echo '<tr>
											
											<td>'.$row['lrn'].'</td>
											<td>'.utf8_encode($row['Lname'].'</td>
											<td>'.$row['FName'].'</td>
											<td>'.$row['MName']).'</td>
											<td style="text-align:center;">'.$row['Gender'].'</td>
											<td>'.$row['Birthdate'].'</td>
											<td>'.$row['SchoolName'].'</td>
											
											<td style="text-align:center;">
											<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($row['lrn'])).'&v='.urlencode(base64_encode("profile")).'" title="View" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a>
														
													</td>
                                        </tr>';
                                    //Add Subject
									
									if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
									{
										
										$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_senior_sub_strand ON class_program.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."'");
											while ($subrow=mysqli_fetch_array($subsched))
											{
												
												mysqli_query($con,"INSERT INTO tbl_shs_tor VALUES(NULL,'".$_SESSION['Grade_Level']."','".$subrow['StrandsubCode']."','0','0','".$_SESSION['Sem']."','".$_SESSION['year']."','".$row['lrn']."','".$_SESSION['CurrentCode']."')");	
												
											}
									}else{
									
									$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_jhs_subject ON class_program.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' ");
										while ($subrow=mysqli_fetch_array($subsched))
										{
											
											mysqli_query($con,"INSERT INTO junior_tor VALUES(NULL,'".$_SESSION['Grade_Level']."','".$subrow['SubNo']."','0','0','0','0','".$_SESSION['year']."','".$row['lrn']."','".$_SESSION['CurrentCode']."')");	
											
										}
									
									
									}
									}
								
									?>
                                </tbody>
                            </table>
				
				  </div>
		  </div><!-- Modal for Re-assign-->
