	 
		
			<div class="row">
                <div class="col-lg-12">
                    <h3></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>               
			   <div class="col-lg-12">
                    <div class="panel panel-default">
                         <div class="panel-heading">
						 <?php
						
                       echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'" class="btn btn-secondary" style="float:right;margin:4px;">BACK </a>';
						?> 
						 <a href="print_sf4.php?v=7e9ff1f60111f1bf6a3696b2092ac4a7285cd942" class="btn btn-primary" style="float:right;" target="_blank">Print SF4</a>
							<h4>List by Sections</h4>
							 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
							
                            <?php
							$tot=$totm=$totf=0;
							if ($_SESSION['Category']=='Elementary')
							{
								echo '<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">
										<thead>
										
											<tr>
												<th>#</th>
												<th>Grade & Section Name</th>
												<th>Class Adviser</th>
												<th style="text-align:center;">Male</th>
												<th style="text-align:center;">Female</th>
												<th style="text-align:center;">Total</th>
												<th style="text-align:center;width:5%;"></th>
												
											</tr>	
											
										</thead>
										<tbody>';
										$no=$total=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."'  ORDER BY tbl_section.Grade Asc");
											while($row=mysqli_fetch_array($datereg))
										{
											$no++;
											echo '<tr>
													<td>'.$no.'</td>';
													if ($row['Grade']=='Kinder')
													{
													echo '<td>'.$row['Grade'].' - '.$row['SecDesc'].'</td>';
														
													}else{
													echo '<td> Grade '.$row['Grade'].' - '.$row['SecDesc'].'</td>';
													}
													$male=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");
													$female=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");
													$total=mysqli_num_rows($male)+mysqli_num_rows($female);
													echo '<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>														
													<td style="text-align:center;">'.mysqli_num_rows($male).'</td>
													<td style="text-align:center;">'.mysqli_num_rows($female).'</td>
													<td style="text-align:center;">'.$total.'</td>
													<td style="text-align:center;">
														 <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($row['Grade'])).'&Code='.urlencode(base64_encode($row['SecCode'])).'&v='.urlencode(base64_encode("subject_by_section")).'"> VIEW</a>
                               
													
													</td>
													
											</tr>';
										}	
										
										echo '</tbody>
									</table>';
						
							}elseif ($_SESSION['Category']=='Secondary')
							{
								echo '<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%">
										<thead>
										
											<tr>
												<th>#</th>
												<th>Grade & Section Name</th>
												<th>Class Adviser</th>
												<th style="text-align:center;">Male</th>
												<th style="text-align:center;">Female</th>
												<th style="text-align:center;">Total</th>
												<th style="text-align:center;width:5%;"></th>
												
											</tr>	
											
										</thead>
										<tbody>';
										$no=$total=$MaleNo=$FemaleNo=0;
										$datereg=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."'  ORDER BY tbl_section.Grade Asc");
										while($row=mysqli_fetch_array($datereg))
										{
											$no++;
												if ($row['Grade']=='11' || $row['Grade']=='12')
													{
													if ($_SESSION['Sem']=='First Semester')
														{
														$male=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND first_semester.Grade='".$row['Grade']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");
														$female=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn WHERE first_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND first_semester.Grade='".$row['Grade']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");														
														}elseif ($_SESSION['Sem']=='Second Semester')
														{
														$male=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND second_semester.Grade='".$row['Grade']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");
														$female=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn WHERE second_semester.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND second_semester.Grade='".$row['Grade']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");														
														
														}
													}else{
													$male=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Male' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");
													$female=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn WHERE tbl_learners.SecCode='".$row['SecCode']."' AND tbl_student.Gender='Female' AND tbl_learners.Grade='".$row['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' GROUP BY tbl_student.lrn");
													}
													if (mysqli_num_rows($male)<>0)
													{
													$MaleNo=mysqli_num_rows($male);
													}
													if (mysqli_num_rows($female)<>0)
													{
													$FemaleNo=mysqli_num_rows($female);
													}
													$total=$MaleNo+$FemaleNo;
											echo '<tr>
													<td>'.$no.'</td>
													<td>Grade '.$row['Grade'].' - '.$row['SecDesc'].'</td>
													<td>'.$row['Emp_LName'].', '.$row['Emp_FName'].'</td>		
													
													<td style="text-align:center;">'.$MaleNo.'</td>
													<td style="text-align:center;">'.$FemaleNo.'</td>
													<td style="text-align:center;">'.$total.'</td>
													<td style="text-align:center;">
													
													 <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($row['Grade'])).'&Code='.urlencode(base64_encode($row['SecCode'])).'&v='.urlencode(base64_encode("subject_by_section")).'" class="btn btn-info" style="margin:4px;padding:4px;"> VIEW</a>
                               
													
													</td>
													
											</tr>';
										}	
										
										echo '</tbody>
									</table>';
							}	
							
							?>
							
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
           