
	 <div class="wizard" style="margin-bottom: 50px;">
        <div class="wizard-inner">
            <div class="connecting-line"></div>
            <ul class="nav nav-tabs" role="tablist">
			<?php
                 echo '
                <li role="presentation" class="">
                    <a aria-controls="step1" role="tab" title="Study Load" href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($_SESSION['lrn'])).'&v='.urlencode(base64_encode("subject")).'">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-list-alt"></i>
                            </span>
                    </a>
                </li>

                 <li role="presentation" class="">
                    <a aria-controls="step1" role="tab" title="Form 9" href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($_SESSION['lrn'])).'&v='.urlencode(base64_encode("form9")).'">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-close"></i>
                            </span>
                    </a>
                </li>
				
                 <li role="presentation" class="active">
                    <a aria-controls="step1" role="tab" title="Form 10" href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($_SESSION['lrn'])).'&v='.urlencode(base64_encode("form10")).'">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                    </a>
                </li>
				
				
				
				<li role="presentation" class="">
                    <a  href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($_SESSION['lrn'])).'&v='.urlencode(base64_encode("profile")).'" aria-controls="step3" role="tab" title="Learner\'s Profile">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                    </a>
                </li>';
				?>
            </ul>
        </div>
    </div>
	
	<?php
			if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
				{
					if ($_SESSION['Sem']=="First Semester")
						{			
						$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND first_semester.Grade='".$_SESSION['Grade']."'ORDER BY tbl_student.Lname Asc");					
						}
										
					elseif ($_SESSION['Sem']=="Second Semester")
						{
							$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND second_semester.Grade='".$_SESSION['Grade']."'ORDER BY tbl_student.Lname Asc");			
						}	
				}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");	
				}
					
			$data=mysqli_fetch_assoc($myinfo);
					
	
	?>
	
	
	 <div class="row">
            <div class="col-lg-12">
			<?php
			 
					//Adviser
				$myadviser=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['SecCode']."' LIMIT 1");	
				$rowadvic=mysqli_fetch_assoc($myadviser);
				$Middle=mb_strimwidth($rowadvic['Emp_MName'],0,1);
			?>
                <ul class="list-unstyled" style="text-transform:uppercase;">
							
							<li>
								<label style="width:150px;">Learner Name: </label><label> <?php echo $data['Lname'].', '.$data['FName'];?></label>
							</li>
							<li>
								<label style="width:150px;">Grade & Section:</label><label> <?php
									echo 'Grade - '.$_SESSION['Grade'].' '. $data['SecDesc'].'</label>';
									
								?>
							</li>
							 <li>
								<label style="width:150px;">Class Adviser:</label><label><?php
									echo $rowadvic['Emp_FName'].' '.$Middle.'. '.$rowadvic['Emp_LName'].'</label>';
									
								?>
							</li>
						</ul>
					</div>
				</div>
				
				<table width="100%" class="table table-striped table-bordered table-hover">
                              
					 <thead>
						<tr>
															
						    <th rowspan="2" width="25%">Learning Areas</th>
							<th colspan="4" width="25%" style="text-align:center;">Quarter</th>
							<th rowspan="2" width="15%" style="text-align:center;">Final Grade</th>
							<th rowspan="2" width="10%" style="text-align:center;">Remark</th>
																
							</tr>
							<tr>
								<th style="text-align:center;">1</th>
								<th style="text-align:center;">2</th>
								<th style="text-align:center;">3</th>
								<th style="text-align:center;">4</th>
																
							</tr>
							</thead>
							 <tbody>
							<?php
							
							if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
							{
								$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND tbl_shs_tor.SecCode='".$_SESSION['SecCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode='".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode='".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode='".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							
							$no=0;							
							while($subrow=mysqli_fetch_array($mysubject))
							{
							$no++;	
							echo '<tr>
									
									<td>'.$subrow['LearningAreas'].'</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									<td style="text-align:center;">0</td>
									
								</tr>';
							}	
						 ?>
						</tbody>
						</table>