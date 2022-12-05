	
	 <div class="row">
            <div class="col-lg-12">
			<?php
			 
					//Adviser
				$myadviser=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['SecCode']."' LIMIT 1");	
				$rowadvic=mysqli_fetch_assoc($myadviser);
				$Middle=mb_strimwidth($rowadvic['Emp_MName'],0,1);
				echo '<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Grade='.urlencode(base64_encode($_SESSION['Grade'])).'&SubNo='.urlencode(base64_encode($_SESSION['SubCode'])).'&SecCode='.urlencode(base64_encode($_SESSION['SecCode'])).'&v='.urlencode(base64_encode("class_list")).'" style="float:right;" class="btn btn-primary">Back</a>';	
		
			?>
                <ul class="list-unstyled" style="text-transform:uppercase;">
							
							<li>
								<label style="width:150px;">Learner Areas: </label><label><?php echo $_SESSION['LearningAreas'].' '.$_SESSION['Grade']; ?></label>
							</li>
							<li>
								<label style="width:150px;">Grade & Section:</label><label> <?php
									echo 'Grade - '.$_SESSION['Grade'].' '. $rowadvic['SecDesc'].'</label>';
									
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
															
						    <th rowspan="3" width="5%" style="text-align:center;">#</th>
						    <th rowspan="3" width="20%">Learner's Name</th>
							<th colspan="11"style="text-align:center;">Activity Per Module</th>
							<th rowspan="3" width="10%" style="text-align:center;">Initial Grade</th>
							<th rowspan="3" width="10%" style="text-align:center;">Final Grade</th>
							<th rowspan="3" width="10%" style="text-align:center;">Remark</th>
																
							</tr>
							<tr>
								<th style="text-align:center;">1</th>
								<th style="text-align:center;">2</th>
								<th style="text-align:center;">3</th>
								<th style="text-align:center;">4</th>
								<th style="text-align:center;">5</th>
								<th style="text-align:center;">6</th>
								<th style="text-align:center;">7</th>
								<th style="text-align:center;">8</th>
								<th style="text-align:center;">9</th>
								<th style="text-align:center;">10</th>
								<th style="text-align:center;">Total</th>
																
							</tr>
							<?php
							
							 $module=mysqli_query($con,"SELECT * FROM tbl_module_information INNER JOIN tbl_list_of_module_activity ON tbl_module_information.ModuleTitle = tbl_list_of_module_activity.ModuleCode WHERE tbl_module_information.ModuleQuarter='".$_SESSION['Quarter']."' AND tbl_module_information.ModuleSubCode='".$_SESSION['SubCode']."' AND tbl_module_information.ModuleSecCode='".$_SESSION['SecCode']."' AND tbl_module_information.ModuleSY='".$_SESSION['year']."' ORDER BY Filename Asc");
								 while($rowmodule=mysqli_fetch_array($module))
								 {
									 $Item1=$Item2=$Item3=$Item4=$Item5=$Item6=$Item7=$Item8=$Item9=$Item10=$ItemTotal=0;
									$myitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_SESSION['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND SYCode='".$_SESSION['year']."' AND Quarter='".$_SESSION['Quarter']."' AND ModuleCode='".$rowmodule['ModuleCode']."'");
									while($rowitem=mysqli_fetch_array($myitem))
									{
									$Item1=$Item1+$rowitem['ItemNo'];
									}
									$ItemTotal=$Item1+$Item2+$Item3+$Item4+$Item5+$Item6+$Item7+$Item8+$Item9+$Item10;
								 }
							
							  echo '<tr>
								<th style="text-align:center;">'.$Item1.'</th>
								<th style="text-align:center;">'.$Item2.'</th>
								<th style="text-align:center;">'.$Item3.'</th>
								<th style="text-align:center;">'.$Item4.'</th>
								<th style="text-align:center;">'.$Item5.'</th>
								<th style="text-align:center;">'.$Item6.'</th>
								<th style="text-align:center;">'.$Item7.'</th>
								<th style="text-align:center;">'.$Item8.'</th>
								<th style="text-align:center;">'.$Item9.'</th>
								<th style="text-align:center;">'.$Item10.'</th>
								<th style="text-align:center;">'.$ItemTotal.'</th>
																
							</tr>';
							?>
							</thead>
							 <tbody>
							<?php
							$no=0;
									if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
										{
											if ($_SESSION['Sem']=="First Semester")
												{			
												$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."'  AND first_semester.Grade='".$_SESSION['Grade']."' AND first_semester.SecCode='".$_SESSION['SecCode']."'ORDER BY tbl_student.Lname Asc");					
												}
																
											elseif ($_SESSION['Sem']=="Second Semester")
												{
													$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."'  AND second_semester.Grade='".$_SESSION['Grade']."' AND second_semester.SecCode='".$_SESSION['SecCode']."' ORDER BY tbl_student.Lname Asc");			
												}	
										}else{
											$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE  tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_learners.SecCode='".$_SESSION['SecCode']."' ORDER BY tbl_student.Lname Asc");	
										}
											
									while($data=mysqli_fetch_array($myinfo))
									{
										
										$score1=$score2=$score3=$score4=$score5=$score6=$score7=$score8=$score9=$score10=$total=$initial=$grade=0;
										$remark="";
										$myScore=mysqli_query($con,"SELECT * FROM tbl_wr_learner_score WHERE tbl_wr_learner_score.SubCode='".$_SESSION['SubCode']."' AND tbl_wr_learner_score.SY ='".$_SESSION['year']."' AND tbl_wr_learner_score.Quarter='".$_SESSION['Quarter']."' AND tbl_wr_learner_score.Activity_SecCode ='".$_SESSION['SecCode']."' AND tbl_wr_learner_score.lrn='".$data['lrn']."'");
										while($rowscore=mysqli_fetch_array($myScore))
										{
											$score1=$score1+$rowscore['Score'];
										}
										//Total Score
										$total=$score1+$score2+$score3+$score4+$score5+$score6+$score7+$score8+$score9+$score10;
										//Initial Grade
										if ($total<>0)
										{
										$initial=($total/$Item1)*100;
										}else{
											$initial=0;
										}
										//Transmuted Grade
										
										if ($initial>=99.99){$grade='100';}elseif ($initial>=97 AND $initial<=98.39){$grade='99';}elseif ($initial>=95.20 AND $initial<=96.79){$grade='98';}elseif ($initial>=93.60 AND $initial<=95.19)
										{$grade='97';}elseif ($initial>=92 AND $initial<=93.59){$grade='96';}elseif ($initial>=90.40 AND $initial<=91.99){$grade='95';}elseif ($initial>=88.80 AND $initial<=90.39){$grade='94';}
									    elseif ($initial>=87.20 AND $initial<=88.79){$grade='93';}elseif ($initial>=85.60 AND $initial<=87.19){$grade='92';}elseif ($initial>=84 AND $initial<=85.59){$grade='91';}elseif ($initial>=82.40 AND $initial<=83.99)
										{$grade='90';}elseif ($initial>=80.80 AND $initial<=82.39){$grade='89';}elseif ($initial>=79.20 AND $initial<=80.79){$grade='88';}elseif ($initial>=77.60 AND $initial<=79.19){$grade='87';}
										elseif ($initial>=76 AND $initial<=77.59){$grade='86';}elseif ($initial>=74.40 AND $initial<=75.99){$grade='85';}elseif ($initial>=95.20 AND $initial<=74.39){$grade='84';}elseif ($initial>=71.20 AND $initial<=72.79)
										{$grade='83';}elseif ($initial>=69.60 AND $initial<=71.19){$grade='82';}elseif ($initial>=68 AND $initial<=69.59){$grade='81';}elseif ($initial>=66.40 AND $initial<=67.99){$grade='80';}elseif ($initial>=64.80 AND $initial<=66.39)
										{$grade='79';}elseif ($initial>=63.20 AND $initial<=64.79){$grade='78';}elseif ($initial>=61.60 AND $initial<=63.19){$grade='77';}elseif ($initial>=60 AND $initial<=61.59){$grade='76';}elseif ($initial>=56 AND $initial<=59.99)
										{$grade='75';}elseif ($initial>=52 AND $initial<=55.99){$grade='74';}elseif ($initial>=48 AND $initial<=51.99){$grade='73';}elseif ($initial>=44 AND $initial<=47.99){$grade='72';}
										elseif ($initial>=40 AND $initial<=43.99){$grade='71';}elseif ($initial>=36 AND $initial<=39.99){$grade='70';}elseif ($initial>=32 AND $initial<=35.99){$grade='69';}elseif ($initial>=27 AND $initial<=31.99){$grade='68';}elseif ($initial>=24 AND $initial<=27.99)
										{$grade='67';}elseif ($initial>=20 AND $initial<=23.99){$grade='66';}elseif ($initial>=16 AND $initial<=19.99){$grade='65';}elseif ($initial>=12 AND $initial<=15.99){$grade='64';}elseif ($initial>=8 AND $initial<=11.99)
										{$grade='63';}elseif ($initial>=4 AND $initial<=7.99){$grade='62';}elseif ($initial>=2 AND $initial<=3.99){$grade='61';}elseif ($initial>=0 AND $initial>=1.99){$grade='60';}elseif ($initial==0){$grade='0';}
										
										
										  //Remarks
										if ($grade>=89)
										{
											 $remark='Outstanding';	
										}elseif ($grade>=84 AND $grade<=88)
										{
											 $remark='Very Satisfactory';	
										}elseif ($grade>=79 AND $grade<=83)
										{
											 $remark='Satisfactory';	
										}elseif ($grade>=74 AND $grade<=78)
										{
											 $remark='Fairly Satisfactory';	
										}elseif ($grade>=0 AND $grade<=73)
										{
											 $remark='Did Not Meet Expectations';	
										}
										
										$no++;
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$score1.'</td>
												<td style="text-align:center;">'.$score2.'</td>
												<td style="text-align:center;">'.$score3.'</td>
												<td style="text-align:center;">'.$score4.'</td>
												<td style="text-align:center;">'.$score5.'</td>
												<td style="text-align:center;">'.$score6.'</td>
												<td style="text-align:center;">'.$score7.'</td>
												<td style="text-align:center;">'.$score8.'</td>
												<td style="text-align:center;">'.$score9.'</td>
												<td style="text-align:center;">'.$score10.'</td>
												<td style="text-align:center;">'.$total.'</td>
												<td style="text-align:center;">'.number_format($initial,1).'</td>
												<td style="text-align:center;">'.number_format($grade,0).'</td>
												<td style="text-align:center;">'.$remark.'</td>
											</tr>';
											
									}
											
							
							?>
	
							
						</tbody>
						</table>