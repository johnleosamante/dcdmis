<div class="col-lg-7">
      
		<div class="alert alert-success" style="color:black;border-radius:.3em;text-align:justify;width:100%;">
		<?php
			if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
			{
			$subject=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode = class_program.SubNo WHERE tbl_senior_sub_strand.StrandsubCode='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_SESSION['SecCode']."' LIMIT 1");	
			}elseif($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10)
			{
			   $subject=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE tbl_jhs_subject.SubNo='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_SESSION['SecCode']."'LIMIT 1");
	
			}else{
				$subject=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE tbl_element_subject.SubNo='".$_SESSION['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_SESSION['SecCode']."' LIMIT 1");

			}
			$rowdata=mysqli_fetch_assoc($subject);
			echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&m='.urlencode(base64_encode($_SESSION['ActivityCode'])).'&ItemNo='.urlencode(base64_encode('1')).'&Item='.urlencode(base64_encode($_SESSION['Item'])).'&Type='.urlencode(base64_encode($_SESSION['ActType'])).'&Name='.urlencode(base64_encode($_SESSION['Name'])).'&v='.urlencode(base64_encode("written_work_set_work")).'" class="btn btn-secondary" style="float:right;">Back</a>';
			echo '<label style="width:150px;text-transform:uppercase;">Learning Area:</label><label>'.$rowdata['LearningAreas'].' '.$_SESSION['Grade'].'</label><br/>
			<label style="width:150px;text-transform:uppercase;">Time & Day :</label><label>'.$rowdata['SecTime'].' '.$rowdata['SecDay'].'</label><br/>
			<label style="width:150px;text-transform:uppercase;">Grade & Section:</label><label>'.$_SESSION['Grade'].' - '.$_SESSION['Sectiondata'].'</label>';
			?>		
		  <a href="print_result.php?id?7e9ff1f60111f1bf6a3696b2092ac4a7285cd9427e9ff1f60111f1bf6a3696b2092ac4a7285cd942" class="btn btn-success" style="float:right;" target="_blank">Print Result</a>
			
	   </div>
		<div class="alert alert-danger" style="color:black;border-radius:.3em;text-align:left;width:100%;font-size:20px;">
		 <h4>Class List<h4>
			
				<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%" style="text-align:center;">#</th>
									<th>Learner's Name</th>
									<th width="20%" style="text-align:center;">Score</th>
									<th width="7%" style="text-align:center;"></th>
									</tr>
						    </thead>
							<tbody>
							<?php
							if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
							{
								if ($_SESSION['Sem']=='First Semester')
								{
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn=tbl_student.lrn INNER JOIN tbl_school ON first_semester.SchoolID = tbl_school.SchoolID WHERE first_semester.school_year='".$_SESSION['year']."' AND first_semester.SecCode='".$_SESSION['SecCode']."' AND first_semester.Grade='".$_SESSION['Grade']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn ORDER BY Lname Asc");
									
								}elseif ($_SESSION['Sem']=='Second Semester')
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn=tbl_student.lrn INNER JOIN tbl_school ON second_semester.SchoolID = tbl_school.SchoolID WHERE second_semester.school_year='".$_SESSION['year']."' AND second_semester.SecCode='".$_SESSION['SecCode']."' AND second_semester.Grade='".$_SESSION['Grade']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn ORDER BY Lname Asc");
								}
							}else{
								$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn=tbl_student.lrn INNER JOIN tbl_school ON tbl_learners.SchoolID = tbl_school.SchoolID INNER JOIN tbl_registration ON tbl_learners.lrn=tbl_registration.lrn WHERE tbl_learners.school_year='".$_SESSION['year']."' AND tbl_learners.SecCode='".$_SESSION['SecCode']."' AND tbl_registration.Grade='".$_SESSION['Grade']."' AND tbl_learners.SchoolID='".$_SESSION['SchoolID']."' GROUP BY tbl_student.lrn");

							}	
								
									$no=0;
									while($row=mysqli_fetch_array($myinfo))
									{
										$no++;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score WHERE tbl_activity_learner_score.SubCode='".$_SESSION['SubCode']."' AND tbl_activity_learner_score.lrn='".$row['lrn']."' AND tbl_activity_learner_score.Activity_Code='".$_SESSION['ActivityCode']."' LIMIT 1");
										$rowscore=mysqli_fetch_assoc($myscore);
										echo '<tr>
											
											<td>'.$no.'</td>
											<td>'.utf8_encode($row['Lname'].', '.$row['FName']).'</td>
											<td style="text-align:center;">'.$rowscore['Score'].'</td>
											<td><a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Access='.urlencode(base64_encode($_SESSION['Access'])).'&Item='.urlencode(base64_encode("1")).'&lrn='.urlencode(base64_encode($row['lrn'])).'&v='.urlencode(base64_encode("view_answer")).'">VIEW</a></td>
											</tr>';
											
									}
							
							?>
							</tbody>
							
										
				</table>
				
		</div>
</div>
		

<div class="col-lg-5">
<div class="panel panel-default">
        <div class="panel-heading">
		Learner's Answer
         </div>
																
			<div class="panel-body" style="overflow-x:auto;">
			
	
	</div>
	
</div>
</div>
	  
