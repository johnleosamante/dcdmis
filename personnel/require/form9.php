<?php
    $_SESSION['lrn']=$_GET['lrn'];
         //Add Subject 
		
		 if(isset($_POST['update_grade']))
		 {
		  mysqli_query($con,"UPDATE junior_tor SET First_Grade='".$_POST['first']."',Second_Grade='".$_POST['second']."',Third_Grade='".$_POST['third']."',Fourth_Grade='".$_POST['fourth']."' WHERE GradeNo='".$_SESSION['Grade_Level']."' AND SubNo ='".$_SESSION['FGradeNo']."'AND SYCode='".$_SESSION['year']."' AND lrn='". $_SESSION['lrn']."' LIMIT 1");	 
		  
		  if (mysqli_affected_rows($con)==1)
		  {
			   ?>
					<script type="text/javascript">
						$(document).ready(function(){						
							$('#access').modal({
							show: 'true'
							}); 				
							});
						</script>
											
									 
					<?php 
									
		  }
		 }
							
	//End add subject

			if ($_SESSION['Grade_Level']=='11' || $_SESSION['Grade_Level']=='12')
				{
					if ($_SESSION['Sem']=="First Semester")
						{			
						$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND first_semester.Grade='".$_SESSION['Grade_Level']."'ORDER BY tbl_student.Lname Asc");					
						}
										
					elseif ($_SESSION['Sem']=="Second Semester")
						{
							$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND second_semester.Grade='".$_SESSION['Grade_Level']."'ORDER BY tbl_student.Lname Asc");			
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
				$myadviser=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['CurrentCode']."' LIMIT 1");	
				$rowadvic=mysqli_fetch_assoc($myadviser);
				$Middle=mb_strimwidth($rowadvic['Emp_MName'],0,1);
				
			if ($_SESSION['Grade_Level']=='11' || $_SESSION['Grade_Level']=='12')
			{
				
			}else{
			echo '<a href="form9" style="float:right;" class="btn btn-success" target="_blank">Print Form 9</a>';
            }
			?>
			
			<ul class="list-unstyled" style="text-transform:uppercase;">
							
							<li>
								<label style="width:150px;">Learner Name: </label><label> <?php echo $data['Lname'].', '.$data['FName'];?></label>
							</li>
							<li>
								<label style="width:150px;">Grade & Section:</label><label> <?php
									echo 'Grade - '.$_SESSION['Grade_Level'].' '. $data['SecDesc'].'</label>';
									
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
				<?php
				if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
				{
				
				echo '<table width="100%" class="table table-striped table-bordered table-hover">
                              
					 <thead>
						<tr>
															
						    <th rowspan="2" width="5%" style="text-align:center;">#</th>
						    <th rowspan="2" width="25%">Learning Areas</th>
							<th colspan="2" width="25%" style="text-align:center;">Quarter</th>
							<th rowspan="2" width="15%" style="text-align:center;">Final Grade</th>
							<th rowspan="2" width="10%" style="text-align:center;">Remark</th>
							<th rowspan="2" width="7%" style="text-align:center;"></th>
																
							</tr>
							<tr>
								<th style="text-align:center;">1</th>
								<th style="text-align:center;">2</th>
																
							</tr>
							</thead>
							 <tbody>';
							 							
							$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."'  AND tbl_shs_tor.SYCode='".$_SESSION['year']."'  AND tbl_shs_tor.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							
							$no=0;	
							$total=0;
							$remark="";							
							while($subrow=mysqli_fetch_array($mysubject))
							{
								$total= (number_format($subrow['FGrade'],0)+number_format($subrow['SGrade'],0))/2;
							if ($total>=75)
							{
								$remark='Passed';
							}else{
								$remark='Failed';
							}
							$no++;	
							echo '<tr>
									
									<td style="text-align:center;">'.$no.'</td>
									<td>'.$subrow['LearningAreas'].'</td>
									<td style="text-align:center;">'.$subrow['FGrade'].'</td>
									<td style="text-align:center;">'.$subrow['SGrade'].'</td>
									<td style="text-align:center;">'.$total.'</td>
									<td style="text-align:center;">'.$remark.'</td>
									<td style="text-align:center;"><a href="update_grade.php?code='.urlencode(base64_encode($subrow['No'])).'&subject='.urlencode(base64_encode($subrow['LearningAreas'])).'" data-toggle="modal" data-target="#update_grade" title="Update Grades" class="btn btn-danger"><i class="fa fa-pencil fa-fw"></i></a></td>
									
								</tr>';
							}	
						
						echo '</tbody>
						</table>';
				}else{
					echo '<table width="100%" class="table table-striped table-bordered table-hover">
                              
					 <thead>
						<tr>
															
						    <th rowspan="2" width="5%" style="text-align:center;">#</th>
						    <th rowspan="2" width="25%">Learning Areas</th>
							<th colspan="4" width="25%" style="text-align:center;">Quarter</th>
							<th rowspan="2" width="15%" style="text-align:center;">Final Grade</th>
							<th rowspan="2" width="10%" style="text-align:center;">Remark</th>
							<th rowspan="2" width="7%" style="text-align:center;"></th>
																
							</tr>
							<tr>
								<th style="text-align:center;">1</th>
								<th style="text-align:center;">2</th>
								<th style="text-align:center;">3</th>
								<th style="text-align:center;">4</th>
																
							</tr>
							</thead>
							 <tbody>';
							 
							
							
							
							if ($_SESSION['Grade_Level']>=7 AND $_SESSION['Grade_Level']<=10){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY tbl_jhs_subject.SequenceNo Asc");
							}
							else{
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY tbl_element_subject.SequenceNo Asc");
							}
							$no=0;	
							$total=0;
							$remark="";							
							while($subrow=mysqli_fetch_array($mysubject))
							{
								$total= (number_format($subrow['First_Grade'],0)+number_format($subrow['Second_Grade'],0)+number_format($subrow['Third_Grade'],0)+number_format($subrow['Fourth_Grade'],0))/4;
							if ($total>=75)
							{
								$remark='Passed';
							}else{
								$remark='Failed';
							}
							$no++;	
							echo '<tr>
									
									<td style="text-align:center;">'.$no.'</td>
									<td>'.$subrow['LearningAreas'].'</td>
									<td style="text-align:center;">'.number_format($subrow['First_Grade'],0).'</td>
									<td style="text-align:center;">'.number_format($subrow['Second_Grade'],0).'</td>
									<td style="text-align:center;">'.number_format($subrow['Third_Grade'],0).'</td>
									<td style="text-align:center;">'.number_format($subrow['Fourth_Grade'],0).'</td>
									<td style="text-align:center;">'.number_format($total,0).'</td>
									<td style="text-align:center;">'.$remark.'</td>
									<td style="text-align:center;"><a href="update_grade.php?code='.urlencode(base64_encode($subrow['SubNo'])).'&subject='.urlencode(base64_encode($subrow['LearningAreas'])).'" data-toggle="modal" data-target="#update_grade"title="Update Grades" class="btn btn-danger"><i class="fa fa-pencil fa-fw"></i></a></td>
									
								</tr>';
							}	
						
						echo '</tbody>
						</table>';
				}
						?>
						
						
						<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="update_grade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        
		
		
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign->
		</div>