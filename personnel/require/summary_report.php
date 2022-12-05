<?php
$_SESSION['SubCode']=$_GET['SubCode'];
if(isset($_POST['save_percent']))
{
 $percentquery=mysqli_query($con,"SELECT * FROM tbl_percentage WHERE Sub_Code ='".$_GET['SubCode']."'");
 if (mysqli_num_rows($percentquery)==0)
 {
	 mysqli_query($con,"INSERT INTO tbl_percentage VALUES(NULL,'".$_POST['ww']."','".$_POST['pt']."','".$_POST['qe']."','".$_GET['SubCode']."')");
 }else{
	mysqli_query($con,"UPDATE tbl_percentage SET Written='".$_POST['ww']."',Performance_task='".$_POST['pt']."',Major_Exam='".$_POST['qe']."' WHERE Sub_Code ='".$_GET['SubCode']."'"); 
 }
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
}elseif(isset($_POST['addscore']))
{
	$query=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score WHERE lrn='".$_SESSION['Current_LRN']."' AND Activity_Code='".$_POST['newactivity']."' AND SubCode='".$_SESSION['SubCode']."'");
	if (mysqli_num_rows($query)==0)
	{
	   mysqli_query($con,"INSERT INTO tbl_activity_learner_score VALUES (NULL,'".$_SESSION['SubCode']."','".$_POST['newscore']."','".$_POST['itemNo']."','".$_POST['newactivity']."','".$_SESSION['Current_LRN']."')");	
	}else{
		mysqli_query($con,"UPDATE tbl_activity_learner_score SET Score = '".$_POST['newscore']."'WHERE lrn='".$_SESSION['Current_LRN']."' AND Activity_Code='".$_POST['newactivity']."' AND SubCode='".$_SESSION['SubCode']."' LIMIT 1");
	}
	
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
}elseif(isset($_POST['save_first_performance']))
{
	mysqli_query($con,"INSERT INTO tbl_performance_task VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','First','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."','RECORDED')");
	
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
}elseif(isset($_POST['save_first_quarter']))
{
	mysqli_query($con,"INSERT INTO tbl_major_exam VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','First','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."')");
	
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
}elseif(isset($_POST['save_second_performance']))
{
	mysqli_query($con,"INSERT INTO tbl_performance_task VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','Second','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."','RECORDED')");
	
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
}elseif(isset($_POST['save_second_quarter']))
{
	mysqli_query($con,"INSERT INTO tbl_major_exam VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','Second','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."')");
	
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
}elseif(isset($_POST['save_third_performance']))
{
	mysqli_query($con,"INSERT INTO tbl_performance_task VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','Third','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."','RECORDED')");
	
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
}elseif(isset($_POST['save_third_quarter']))
{
	mysqli_query($con,"INSERT INTO tbl_major_exam VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','Third','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."')");
	
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
}elseif(isset($_POST['save_fourth_performance']))
{
	mysqli_query($con,"INSERT INTO tbl_performance_task VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','Fourth','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."','RECORDED')");
	
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
}elseif(isset($_POST['save_fourth_quarter']))
{
	mysqli_query($con,"INSERT INTO tbl_major_exam VALUES(NULL,'".date("Y-m-d")."','".$_POST['name_of_activity']."','".$_POST['number_of_item']."','Open','".$_SESSION['SubCode']."','".$_SESSION['Grade']."','Fourth','".$_SESSION['SecCode']."','".$_SESSION['year']."','".$_SESSION['SchoolID']."')");
	
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




?>
 <div class="col-lg-12">
 <h3></h3>
 </div>
            <div class="row">
                <div class="col-lg-12">
                   <?php
				  
				  if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
					{
					$subject=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode = class_program.SubNo WHERE tbl_senior_sub_strand.StrandsubCode='".$_GET['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_SESSION['SecCode']."' LIMIT 1");
					}elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
					$subject=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE tbl_jhs_subject.SubNo='".$_GET['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_SESSION['SecCode']."'LIMIT 1");
					}else{
															 
						$subject=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE tbl_element_subject.SubNo='".$_GET['SubCode']."' AND class_program.SchoolID ='".$_SESSION['SchoolID']."' AND class_program.SecCode ='".$_SESSION['SecCode']."' LIMIT 1");
					}
					$rowdata=mysqli_fetch_assoc($subject);	
				    $load=mysqli_query($con,"SELECT * FROM tbl_subject_load INNER JOIN tbl_section ON tbl_subject_load.SecCode=tbl_section.SecCode WHERE tbl_subject_load.Emp_ID='".$_SESSION['EmpID']."' AND tbl_subject_load.School_Year='".$_SESSION['year']."'  AND tbl_subject_load.GradeLevel='".$_SESSION['Grade']."' AND tbl_subject_load.SubCode='".$_GET['SubCode']."' AND tbl_subject_load.SecCode ='".$_SESSION['SecCode']."'LIMIT 1");
					$rowsubject=mysqli_fetch_assoc($load);	
				
					if ($_SESSION['Grade']=='Kinder')
						{
							$grade=	$_SESSION['Grade'];
						}else{
							$grade=	'GRADE '.$_SESSION['Grade'];
						}
						echo '<a href="#newpercent" class="btn btn-primary" style="float:right;" data-toggle="modal">SET SUBJECT PERCENTAGE</a>';
				   echo '<label style="width:150px;text-transform:uppercase;">Learning Area:</label><label>'.$rowdata['LearningAreas'].' '.$_SESSION['Grade'].'</label><br/>
						<label style="width:150px;text-transform:uppercase;">Time & Day :</label><label>'.$rowdata['SecTime'].' '.$rowdata['SecDay'].'</label><br/>
						<label style="width:150px;text-transform:uppercase;">Grade & Section:</label><label>'.$grade.' - '.$rowsubject['SecDesc'].'</label>';
						
						//Subject percentage
						$persubject=mysqli_query($con,"SELECT * FROM tbl_percentage WHERE Sub_Code='".$_GET['SubCode']."' LIMIT 1");
						$perData=mysqli_fetch_assoc($persubject);
						$percentww=$perData['Written']/100;
				   ?>
					
                </div>
                <!-- /.col-lg-12 -->
            </div><hr/>
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#first" data-toggle="tab"> FIRST QUARTER</a>
                                </li>
								<li>
									<a href="#second" data-toggle="tab"> SECOND QUARTER</a>
                                </li>
                                <li >
									<a href="#third" data-toggle="tab"> THIRD QUARTER</a>
                                </li>
								 <li >
									<a href="#fourth" data-toggle="tab"> FOURTH QUARTER</a>
                                </li>
								
							</ul>
			
							<div class="tab-content">
							<div class="tab-pane fade in active" id="first"><br/>
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#firstWW" data-toggle="tab"> WRITTEN WORKS</a>
                                </li>
								<li>
									<a href="#firstPT" data-toggle="tab"> PERFORMANCE TASK</a>
                                </li>
                                <li >
									<a href="#firstQE" data-toggle="tab"> QUARTER EXAM</a>
                                </li>
								 <li >
									<a href="#firstGrade" data-toggle="tab"> GRADE SHEET</a>
                                </li>
								
							</ul>
							<div class="tab-content">
							<?php
							
							 echo '<div class="tab-pane fade in active" id="firstWW">
							 <h4 class="page-header">FIRST QUARTER WRITTEN WORK</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="13" width="70%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
											
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >1</th>
											<th style="text-align:center;" >2</th>
											<th style="text-align:center;" >3</th>
											<th style="text-align:center;" >4</th>
											<th style="text-align:center;" >5</th>
											<th style="text-align:center;" >6</th>
											<th style="text-align:center;" >7</th>
											<th style="text-align:center;" >8</th>
											<th style="text-align:center;" >9</th>
											<th style="text-align:center;" >10</th>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										$totalFirstItemWW=$no=$activ=0;
										 
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'First' AND activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
										$no=mysqli_num_rows($mywwitem);
										echo '<tr>';
										
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										 echo '<th style="text-align:center;">'.$rowww['ItemNo'].'</th>';
										 $totalFirstItemWW= $totalFirstItemWW + $rowww['ItemNo'];
										 $activ++;
										}
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$totalFirstItemWW.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
										</tr>';
                                     ?>
									 </thead>
									 <tbody>
									 <?php
									 $no=$percentww=0;
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
										$percentww=$perData['Written']/100;
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$FirsttotalscoreWW=$Firstmyps=$Firstws=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='First' AND tbl_written_work_set_activity.activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."'  AND Grade_Level='".$_SESSION['Grade']."' AND tbl_written_work_set_activity.Quarter='First' AND activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='First' AND tbl_written_work_set_activity.activity_remark='RECORDED' ORDER BY tbl_written_work_set_activity.QCode Asc");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$FirsttotalscoreWW = $FirsttotalscoreWW + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='First' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($FirsttotalscoreWW<>0)
												{
												$Firstmyps=($FirsttotalscoreWW/$totalFirstItemWW)*100;
												$Firstws=$Firstmyps*$percentww;
												}
												echo '<td style="text-align:center;">'.$FirsttotalscoreWW.'</td>';
												echo '<td style="text-align:center;">'.number_format($Firstmyps,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($Firstws,2).'</td>';
												echo '<td style="text-align:center;"><a href="updatewritten.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('First')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
									  ?> 
									   
									 </tbody>
									 
								</table>		
							 </div>
							 <div class="tab-pane fade" id="firstPT">
							 <a href="#firstptactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Performance Activity Item</a>
							  <?php
							    echo '
							 <h4 class="page-header">FIRST QUARTER PERFORMANCE TASK</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="13" width="70%" style="text-align:center;">PERFORMANCE TASK <br/>['.$perData['Performance_task'].' %]</th>
											
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >1</th>
											<th style="text-align:center;" >2</th>
											<th style="text-align:center;" >3</th>
											<th style="text-align:center;" >4</th>
											<th style="text-align:center;" >5</th>
											<th style="text-align:center;" >6</th>
											<th style="text-align:center;" >7</th>
											<th style="text-align:center;" >8</th>
											<th style="text-align:center;" >9</th>
											<th style="text-align:center;" >10</th>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										$FirstTotalPTItem=$no=0;
										$myfristperformance=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."' AND Quarter ='First'AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' AND activity_remark='RECORDED' ORDER BY Date_created Asc");
										$no=mysqli_num_rows($myfristperformance);
										echo '<tr>';
										while($rowperform=mysqli_fetch_array($myfristperformance))
										{
											echo '<th style="text-align:center;" >'.$rowperform['ItemNo'].'</th>';
											$FirstTotalPTItem=$FirstTotalPTItem+$rowperform['ItemNo'];
										}	
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$FirstTotalPTItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>										
										  </tr>';
										?>
										</thead>
										<tbody>
										<?php
										 $no=$Firstpercentpt=0;
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
										$Firstpercentpt=$perData['Performance_task']/100;
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$FirsttotalPTscore=$FirstmyPTps=$Firstws=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='First' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."'  AND Grade='".$_SESSION['Grade']."' AND tbl_performance_task.Quarter='First' AND activity_remark='RECORDED' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' ORDER BY Date_created Asc");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='First' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$FirsttotalPTscore = $FirsttotalPTscore + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='First' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($FirsttotalPTscore<>0)
												{
												$FirstmyPTps=($FirsttotalPTscore/$FirstTotalPTItem)*100;
												$Firstws=$FirstmyPTps*$Firstpercentpt;
												}
												echo '<td style="text-align:center;">'.$FirsttotalPTscore.'</td>';
												echo '<td style="text-align:center;">'.number_format($FirstmyPTps,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($Firstws,2).'</td>';
												echo '<td style="text-align:center;"><a href="updateperfomance.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('First')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
										?>	
										</tbody>
										</table>
							   
							   
							  </div>
							  
							   <div class="tab-pane fade" id="firstQE">
							   
							   <?php
							   $myQEitemNo=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='First' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
								$noQEItem=mysqli_fetch_assoc($myQEitemNo);
								if ($noQEItem['ItemNo']=="")
								{
								echo '<a href="#newqeactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Quarter Exam Activity Item</a>';		
							    }
								echo '
							 <h4 class="page-header">FIRST QUARTERLY EXAM</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" >Learner\'s Name</th>
											<th  colspan="4"width="10%" style="text-align:center;">QUARTERLY EXAM<br/>['.$perData['Major_Exam'].' %]</th>
											
										</tr>
										<tr>
											<th style="text-align:center;width:10%;" >1</th>	
											<th width="10%" style="text-align:center;" >TOTAL</th>
											<th width="10%" style="text-align:center;" >PS</th>
											<th width="10%" style="text-align:center;" >WS</th>												
										</tr>
										<tr>
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >100</th>										
											<th style="text-align:center;" >'.$perData['Major_Exam'].'</th>	
																					
										</tr>
										</thead>
										<tbody>';
										
										 $no=$FirstQEPercentage=0;
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
												$FirstQEPercentage=$perData['Major_Exam']/100;
											while($data=mysqli_fetch_array($myinfo))
											{
												$no++;
												$FirstmyQEps=$FirstwsQE=0;
												$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='First' ORDER BY tbl_major_exam.Date_created Asc LIMIT 1");
												$QEscore=mysqli_fetch_assoc($myscore);
												
												//PT and WS
												if ($QEscore['Score']<>0)
												{
												$FirstmyQEps=($QEscore['Score']/$noQEItem['ItemNo'])*100;
												$FirstwsQE=$FirstmyQEps*$FirstQEPercentage;
												}
											echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.number_format($FirstmyQEps,2).'</td>
												<td style="text-align:center;">'.number_format($FirstwsQE,2).'</td>
												<td style="text-align:center;"><a href="updateQuarterExam.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('First')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>
												
												</tr>';
											}	
										?>
										</tbody>
										</table>
							  
							  
							  
							  
							  </div>
							  
							  <div class="tab-pane fade" id="firstGrade">
							   <a href="print_grade" class="btn btn-primary" style="float:right;" target="_blank">PRINT GRADE SHEET</a>
								<h4 class="page-header">FIRST QUARTER GRADE SHEET</h4>
								<?php
								echo '<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="3" width="15%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">PERFORMANCE TASKS <br/> ['.$perData['Performance_task'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">QUARTERLY ASSESSMENT <br/>['.$perData['Major_Exam'].' %]</th>
											<th rowspan="2" width="15%" style="text-align:center;">INITIAL GRADE</th>
											<th rowspan="2" width="15%" style="text-align:center;">QUARTERLY GRADE</th>
											<th rowspan="3" width="15%" style="text-align:center;">DESCRIPTION</th>
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
											
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										//Written Work Scoring Information
										$totalItem=$no=$nopt=$totalPTItem=0;
										$percentfirstww=$perData['Written']/100;
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'First' AND activity_remark='RECORDED'");
										$no=mysqli_num_rows($mywwitem);
										
										//Performance Task	Scoring Information	
										$percentfirstpt=$perData['Performance_task']/100;
										$myptitem=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='First'AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND activity_remark='RECORDED' AND Grade ='".$_SESSION['Grade']."'ORDER BY Date_created Asc");
										$nopt=mysqli_num_rows($myptitem);
										
										//Quarterly Exam	Scoring Information	
										$percentfirstQE=$perData['Major_Exam']/100;
										$myQEitem=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='First' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
										$noQE=mysqli_fetch_assoc($myQEitem);
										
										echo '<tr>';
										//Total Number of WRITTEN work Item
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										
										 $totalItem= $totalItem + $rowww['ItemNo'];
										
										}
											//Total Number of Performance Task Item
										while($rowpt=mysqli_fetch_array($myptitem))	
										{
										
										 $totalPTItem= $totalPTItem + $rowpt['ItemNo'];
										
										}
										echo '<th style="text-align:center;">'.$totalItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
											<th style="text-align:center;">'.$totalPTItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>
											<th style="text-align:center;">'.$noQE['ItemNo'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Major_Exam'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">100</th>
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
										$no++;
										$remarks="";
										$firsttotalwwscore=$firstwwps=$firstwwws=0;
										$firsttotalptscore=$firstptps=$firstptws=0;
										$firsttotalQEscore=$firstQEps=$firstQEws=0;
										$firstqaurterInitialGrade=$FirstQuarterGrade=0;
										//First Quarter Written Work
										$mywwscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='First' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
										while($rowfirstscore=mysqli_fetch_array($mywwscore))
										{
										$firsttotalwwscore=$firsttotalwwscore+	$rowfirstscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalItem<>0)
										{
										$firstwwps=($firsttotalwwscore/$totalItem)*100;
										$firstwwws=$firstwwps*$percentfirstww;
										}
										//First Quarter Performance Task
										$myPTcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='First' AND tbl_performance_task.activity_remark='RECORDED' AND tbl_performance_task.SecCode='".$_SESSION['SecCode']."' AND tbl_performance_task.SYCode='".$_SESSION['year']."' AND tbl_performance_task.SchoolID='".$_SESSION['SchoolID']."' AND tbl_performance_task.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstptscore=mysqli_fetch_array($myPTcore))
										{
										$firsttotalptscore=$firsttotalptscore +	$rowfirstptscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalPTItem<>0)
										{
										$firstptps=($firsttotalptscore/$totalPTItem)*100;
										$firstptws=$firstptps*$percentfirstpt;
										}
										//First Quarter Quarterly Exam
										$myQEcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='First' AND tbl_major_exam.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.SecCode='".$_SESSION['SecCode']."' AND tbl_major_exam.SYCode='".$_SESSION['year']."' AND tbl_major_exam.SchoolID='".$_SESSION['SchoolID']."' AND tbl_major_exam.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstQEscore=mysqli_fetch_array($myQEcore))
										{
										$firsttotalQEscore=$firsttotalQEscore +	$rowfirstQEscore['Score'];
										}
										
										//Calculate firstwwps
										if ($noQE['ItemNo']<>0)
										{
										$firstQEps=($firsttotalQEscore/$noQE['ItemNo'])*100;
										$firstQEws=$firstQEps*$percentfirstQE;
										}
										//Initial Grades
										$firstqaurterInitialGrade=$firstwwws+$firstptws+$firstQEws;
										
										//First Quarter Grade
										if ($firstqaurterInitialGrade>="99.99"){$FirstQuarterGrade="100";}elseif ($firstqaurterInitialGrade>="98.39" AND $firstqaurterInitialGrade<="99.98"){$FirstQuarterGrade="99";}elseif ($firstqaurterInitialGrade>='96.79' AND $firstqaurterInitialGrade<='98.38')
										{$FirstQuarterGrade='98';}elseif ($firstqaurterInitialGrade>='95.19' AND $firstqaurterInitialGrade<='96.78'){$FirstQuarterGrade='97';}elseif ($firstqaurterInitialGrade>='93.59' AND $firstqaurterInitialGrade<='95.18')
										{$FirstQuarterGrade='96';}elseif ($firstqaurterInitialGrade>='91.99' AND $firstqaurterInitialGrade<='93.58'){$FirstQuarterGrade='95';}elseif ($firstqaurterInitialGrade>='90.39' AND $firstqaurterInitialGrade<='91.98')
										{$FirstQuarterGrade='94';}elseif ($firstqaurterInitialGrade>='88.79' AND $firstqaurterInitialGrade<='90.38'){$FirstQuarterGrade='93';}elseif ($firstqaurterInitialGrade>='87.19' AND $firstqaurterInitialGrade<='88.78')
										{$FirstQuarterGrade='92';}elseif ($firstqaurterInitialGrade>='85.59' AND $firstqaurterInitialGrade<='87.18'){$FirstQuarterGrade='91';}elseif ($firstqaurterInitialGrade>='83.99' AND $firstqaurterInitialGrade<='85.59')
										{$FirstQuarterGrade='90';}elseif ($firstqaurterInitialGrade>='82.39' AND $firstqaurterInitialGrade<='83.98'){$FirstQuarterGrade='89';}elseif ($firstqaurterInitialGrade>='80.79' AND $firstqaurterInitialGrade<='82.38')
										{$FirstQuarterGrade='88';}elseif ($firstqaurterInitialGrade>='79.19' AND $firstqaurterInitialGrade<='80.78'){$FirstQuarterGrade='87';}elseif ($firstqaurterInitialGrade>='77.59' AND $firstqaurterInitialGrade<='79.18')
										{$FirstQuarterGrade='86';}elseif ($firstqaurterInitialGrade>='75.99' AND $firstqaurterInitialGrade<='77.58'){$FirstQuarterGrade='85';}elseif ($firstqaurterInitialGrade>='74.39' AND $firstqaurterInitialGrade<='75.98')
										{$FirstQuarterGrade='84';}elseif ($firstqaurterInitialGrade>='72.79' AND $firstqaurterInitialGrade<='74.38'){$FirstQuarterGrade='83';}elseif ($firstqaurterInitialGrade>='71.19' AND $firstqaurterInitialGrade<='72.78')
										{$FirstQuarterGrade='82';}elseif ($firstqaurterInitialGrade>='69.59' AND $firstqaurterInitialGrade<='71.18'){$FirstQuarterGrade='81';}elseif ($firstqaurterInitialGrade>='67.99' AND $firstqaurterInitialGrade<='69.58')
										{$FirstQuarterGrade='80';}elseif ($firstqaurterInitialGrade>='66.39' AND $firstqaurterInitialGrade<='67.98'){$FirstQuarterGrade='79';}elseif ($firstqaurterInitialGrade>='64.79' AND $firstqaurterInitialGrade<='66.38')
										{$FirstQuarterGrade='78';}elseif ($firstqaurterInitialGrade>='63.19' AND $firstqaurterInitialGrade<='64.78'){$FirstQuarterGrade='77';}elseif ($firstqaurterInitialGrade>='61.59' AND $firstqaurterInitialGrade<='63.18')
										{$FirstQuarterGrade='76';}elseif ($firstqaurterInitialGrade>='59.99' AND $firstqaurterInitialGrade<='61.58'){$FirstQuarterGrade='75';}elseif ($firstqaurterInitialGrade>='55.99' AND $firstqaurterInitialGrade<='59.98')
										{$FirstQuarterGrade='74';}elseif ($firstqaurterInitialGrade>='51.99' AND $firstqaurterInitialGrade<='55.98'){$FirstQuarterGrade='73';}elseif ($firstqaurterInitialGrade>='47.99' AND $firstqaurterInitialGrade<='51.98')
										{$FirstQuarterGrade='72';}elseif ($firstqaurterInitialGrade>='43.99' AND $firstqaurterInitialGrade<='47.98'){$FirstQuarterGrade='71';}elseif ($firstqaurterInitialGrade>='39.99' AND $firstqaurterInitialGrade<='43.98')
										{$FirstQuarterGrade='70';}elseif ($firstqaurterInitialGrade>='35.99' AND $firstqaurterInitialGrade<='39.98'){$FirstQuarterGrade='69';}elseif ($firstqaurterInitialGrade>='31.99' AND $firstqaurterInitialGrade<='735.98')
										{$FirstQuarterGrade='68';}elseif ($firstqaurterInitialGrade>='27.99' AND $firstqaurterInitialGrade<='31.98'){$FirstQuarterGrade='67';}elseif ($firstqaurterInitialGrade>='23.99' AND $firstqaurterInitialGrade<='27.98')
										{$FirstQuarterGrade='66';}elseif ($firstqaurterInitialGrade>='19.99' AND $firstqaurterInitialGrade<='23.98'){$FirstQuarterGrade='65';}elseif ($firstqaurterInitialGrade>='15.99' AND $firstqaurterInitialGrade<='19.98')
										{$FirstQuarterGrade='64';}elseif ($firstqaurterInitialGrade>='11.99' AND $firstqaurterInitialGrade<='15.98'){$FirstQuarterGrade='63';}elseif ($firstqaurterInitialGrade>='7.99' AND $firstqaurterInitialGrade<='11.98')
										{$FirstQuarterGrade='62';}elseif ($firstqaurterInitialGrade>='3.99' AND $firstqaurterInitialGrade<='7.98'){$FirstQuarterGrade='61';}elseif ($firstqaurterInitialGrade>='0' AND $firstqaurterInitialGrade<='3.98'){$FirstQuarterGrade='60';}
										
										//First Quarter Remarks
										if ($FirstQuarterGrade>=89){$remarks="Outstanding";}elseif ($FirstQuarterGrade>=84 AND $FirstQuarterGrade<=88)
										{$remarks="Very Satisfactory";}elseif ($FirstQuarterGrade>=79 AND $FirstQuarterGrade<=83){$remarks="Satisfactory";
										}elseif ($FirstQuarterGrade>=74 AND $FirstQuarterGrade<=78){$remarks="Fairly Satisfactory";}elseif ($FirstQuarterGrade>=59 AND $FirstQuarterGrade<=73){$remarks="Did Not Meet Expectations";}
										
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$firsttotalwwscore.'</td>
												<td style="text-align:center;">'.number_format($firstwwps,2).'</td>
												<td style="text-align:center;">'.number_format($firstwwws,2).'</td>
												<td style="text-align:center;">'.$firsttotalptscore.'</td>
												<td style="text-align:center;">'.number_format($firstptps,2).'</td>
												<td style="text-align:center;">'.number_format($firstptws,2).'</td>
												<td style="text-align:center;">'.$firsttotalQEscore.'</td>
												<td style="text-align:center;">'.number_format($firstQEps,2).'</td>
												<td style="text-align:center;">'.number_format($firstQEws,2).'</td>
												<td style="text-align:center;">'.number_format($firstqaurterInitialGrade,2).'</td>
												<td style="text-align:center;">'.number_format($FirstQuarterGrade,0).'</td>
												<td style="text-align:center;">'.$remarks.'</td>
												
											 </tr>';
									}  
									  ?> 
									   
									 </tbody>
									 
								</table>
							  
							  </div>
							 </div>
							 </div>
							 <!--End of First Quarter-->
							
								
							 
							 
							  <div class="tab-pane fade" id="second"><br/>
							  <div class="tab-content">
									<div class="tab-pane fade in active" id="second">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#secondWW" data-toggle="tab"> WRITTEN WORKS</a>
										</li>
										<li>
											<a href="#secondPT" data-toggle="tab"> PERFORMANCE TASK</a>
										</li>
										<li >
											<a href="#secondQE" data-toggle="tab"> QUARTER EXAM</a>
										</li>
										 <li >
											<a href="#secondGrade" data-toggle="tab"> GRADE SHEET</a>
										</li>
										
									</ul>
									<div class="tab-content">
									  <div class="tab-pane fade  in active" id="secondWW">
									  
									   <h4 class="page-header">SECOND QUARTER WRITTEN WORK</h4>
										<?php
										echo '<table width="100%" class="table table-striped table-bordered table-hover">		  
											 <thead>
												<tr>							
													<th rowspan="3" width="5%" style="text-align:center;">#</th>
													<th rowspan="3" width="20%">Learner\'s Name</th>
													<th colspan="13" width="70%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
													
												</tr>';
												?>
												<tr>
													<th style="text-align:center;" >1</th>
													<th style="text-align:center;" >2</th>
													<th style="text-align:center;" >3</th>
													<th style="text-align:center;" >4</th>
													<th style="text-align:center;" >5</th>
													<th style="text-align:center;" >6</th>
													<th style="text-align:center;" >7</th>
													<th style="text-align:center;" >8</th>
													<th style="text-align:center;" >9</th>
													<th style="text-align:center;" >10</th>
													<th style="text-align:center;" >TOTAL</th>
													<th style="text-align:center;" >PS</th>
													<th style="text-align:center;" >WS</th>
												</tr>
												<?php
												$totalSecondItemww=$no=$activ=0;
										 
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'Second' AND activity_remark='RECORDED'");
										$no=mysqli_num_rows($mywwitem);
										echo '<tr>';
										
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										 echo '<th style="text-align:center;">'.$rowww['ItemNo'].'</th>';
										 $totalSecondItemww= $totalSecondItemww + $rowww['ItemNo'];
										 $activ++;
										}
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$totalSecondItemww.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
										</tr>';
                                     ?>
									 </thead>
									 <tbody>
									 <?php
									 $no=$percentSecondww=0;
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
										$percentSecondww=$perData['Written']/100;
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$totalSecondscore=$mysecondps=$secondws=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Second' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."'  AND Grade_Level='".$_SESSION['Grade']."' AND tbl_written_work_set_activity.Quarter='First' AND activity_remark='RECORDED'");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Second' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$totalSecondscore = $totalSecondscore + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Second' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($totalSecondscore<>0)
												{
												$mysecondps=($totalSecondscore/$totalSecondItemww)*100;
												$secondws=$mysecondps*$percentSecondww;
												}
												echo '<td style="text-align:center;">'.$totalSecondscore.'</td>';
												echo '<td style="text-align:center;">'.number_format($mysecondps,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($secondws,2).'</td>';
												echo '<td style="text-align:center;"><a href="updatewritten.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Second')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
									  ?> 
									   
									 </tbody>
									 
								</table>		
							 </div>
							  <div class="tab-pane fade" id="secondPT">
							  <a href="#secondptactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Performance Activity Item</a>
							
							  <?php
							    echo '
							 <h4 class="page-header">SECOND QUARTER PERFORMANCE TASK</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="13" width="70%" style="text-align:center;">PERFORMANCE TASK <br/>['.$perData['Performance_task'].' %]</th>
											
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >1</th>
											<th style="text-align:center;" >2</th>
											<th style="text-align:center;" >3</th>
											<th style="text-align:center;" >4</th>
											<th style="text-align:center;" >5</th>
											<th style="text-align:center;" >6</th>
											<th style="text-align:center;" >7</th>
											<th style="text-align:center;" >8</th>
											<th style="text-align:center;" >9</th>
											<th style="text-align:center;" >10</th>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										$TotalISecondtemPT=$no=0;
										$myfristperformance=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."' AND Quarter ='Second' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' AND activity_remark='RECORDED' ORDER BY Date_created Asc");
										$no=mysqli_num_rows($myfristperformance);
										echo '<tr>';
										while($rowperform=mysqli_fetch_array($myfristperformance))
										{
											echo '<th style="text-align:center;" >'.$rowperform['ItemNo'].'</th>';
											$TotalISecondtemPT=$TotalISecondtemPT+$rowperform['ItemNo'];
										}	
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$TotalISecondtemPT.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>										
										  </tr>';
										?>
										</thead>
										<tbody>
										<?php
										 $no=$percentSecondpt=0;
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
										$percentSecondpt=$perData['Performance_task']/100;
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$totalSecondPTscore=$SecondPTmyps=$SecondPTws=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Second' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."'  AND Grade='".$_SESSION['Grade']."' AND tbl_performance_task.Quarter='Second' AND activity_remark='RECORDED' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' ORDER BY Date_created Asc");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Second' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$totalSecondPTscore = $totalSecondPTscore + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Second' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($totalSecondPTscore<>0)
												{
												$SecondPTmyps=($totalSecondPTscore/$TotalISecondtemPT)*100;
												$SecondPTws=$SecondPTmyps*$percentSecondpt;
												}
												echo '<td style="text-align:center;">'.$totalSecondPTscore.'</td>';
												echo '<td style="text-align:center;">'.number_format($SecondPTmyps,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($SecondPTws,2).'</td>';
												echo '<td style="text-align:center;"><a href="updateperfomance.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Second')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
									?>	
										</tbody>
										</table>
							   
							 
							 </div>
							  <div class="tab-pane fade" id="secondQE">
							 
							    <?php
							   $myQEitemNo=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Second' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
								$noQEItem=mysqli_fetch_assoc($myQEitemNo);
								if ($noQEItem['ItemNo']=="")
								{
								echo '<a href="#secondqeactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Quarter Exam Activity Item</a>';		
							    }
								echo '
							 <h4 class="page-header">SECOND QUARTERLY EXAM</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" >Learner\'s Name</th>
											<th  colspan="4"width="10%" style="text-align:center;">QUARTERLY EXAM<br/>['.$perData['Major_Exam'].' %]</th>
											
										</tr>
										<tr>
											<th style="text-align:center;width:10%;" >1</th>	
											<th width="10%" style="text-align:center;" >TOTAL</th>
											<th width="10%" style="text-align:center;" >PS</th>
											<th width="10%" style="text-align:center;" >WS</th>												
										</tr>
										<tr>
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >100</th>										
											<th style="text-align:center;" >'.$perData['Major_Exam'].'</th>	
																					
										</tr>
										</thead>
										<tbody>';
										
										 $no=$percentQE=0;
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
												$percentQE=$perData['Major_Exam']/100;
											while($data=mysqli_fetch_array($myinfo))
											{
												$no++;
												$myQEps=$wsQE=0;
												$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='Second' ORDER BY tbl_major_exam.Date_created Asc LIMIT 1");
												$QEscore=mysqli_fetch_assoc($myscore);
												
												//PT and WS
												if ($QEscore['Score']<>0)
												{
												$myQEps=($QEscore['Score']/$noQEItem['ItemNo'])*100;
												$wsQE=$myQEps*$percentQE;
												}
											echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.number_format($myQEps,2).'</td>
												<td style="text-align:center;">'.number_format($wsQE,2).'</td>
												<td style="text-align:center;"><a href="updateQuarterExam.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Second')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>
												
												</tr>';
											}	
										?>
										</tbody>
										</table>
							  
							  
							 </div>
							 <div class="tab-pane fade" id="secondGrade">
							  <a href="print_grade" class="btn btn-primary" style="float:right;" target="_blank">PRINT GRADE SHEET</a>
								<h4 class="page-header">SECOND QUARTER GRADE SHEET</h4>
								<?php
								echo '<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="3" width="15%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">PERFORMANCE TASKS <br/> ['.$perData['Performance_task'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">QUARTERLY ASSESSMENT <br/>['.$perData['Major_Exam'].' %]</th>
											<th rowspan="2" width="15%" style="text-align:center;">INITIAL GRADE</th>
											<th rowspan="2" width="15%" style="text-align:center;">QUARTERLY GRADE</th>
											<th rowspan="3" width="15%" style="text-align:center;">DESCRIPTION</th>
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
											
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										//Written Work Scoring Information
										$totalItem=$no=$nopt=$totalPTItem=0;
										$percentfirstww=$perData['Written']/100;
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'Second' AND activity_remark='RECORDED'");
										$no=mysqli_num_rows($mywwitem);
										
										//Performance Task	Scoring Information	
										$percentfirstpt=$perData['Performance_task']/100;
										$myptitem=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Second' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND activity_remark='RECORDED' AND Grade ='".$_SESSION['Grade']."'ORDER BY Date_created Asc");
										$nopt=mysqli_num_rows($myptitem);
										
										//Quarterly Exam	Scoring Information	
										$percentfirstQE=$perData['Major_Exam']/100;
										$myQEitem=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Second' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
										$noQE=mysqli_fetch_assoc($myQEitem);
										
										echo '<tr>';
										//Total Number of WRITTEN work Item
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										
										 $totalItem= $totalItem + $rowww['ItemNo'];
										
										}
											//Total Number of Performance Task Item
										while($rowpt=mysqli_fetch_array($myptitem))	
										{
										
										 $totalPTItem= $totalPTItem + $rowpt['ItemNo'];
										
										}
										echo '<th style="text-align:center;">'.$totalItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
											<th style="text-align:center;">'.$totalPTItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>
											<th style="text-align:center;">'.$noQE['ItemNo'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Major_Exam'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">100</th>
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
										$no++;
										$remarks="";
										$firsttotalwwscore=$firstwwps=$firstwwws=0;
										$firsttotalptscore=$firstptps=$firstptws=0;
										$firsttotalQEscore=$firstQEps=$firstQEws=0;
										$firstqaurterInitialGrade=$FirstQuarterGrade=0;
										//First Quarter Written Work
										$mywwscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Second' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
										while($rowfirstscore=mysqli_fetch_array($mywwscore))
										{
										$firsttotalwwscore=$firsttotalwwscore+	$rowfirstscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalItem<>0)
										{
										$firstwwps=($firsttotalwwscore/$totalItem)*100;
										$firstwwws=$firstwwps*$percentfirstww;
										}
										//First Quarter Performance Task
										$myPTcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Second' AND tbl_performance_task.activity_remark='RECORDED' AND tbl_performance_task.SecCode='".$_SESSION['SecCode']."' AND tbl_performance_task.SYCode='".$_SESSION['year']."' AND tbl_performance_task.SchoolID='".$_SESSION['SchoolID']."' AND tbl_performance_task.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstptscore=mysqli_fetch_array($myPTcore))
										{
										$firsttotalptscore=$firsttotalptscore +	$rowfirstptscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalPTItem<>0)
										{
										$firstptps=($firsttotalptscore/$totalPTItem)*100;
										$firstptws=$firstptps*$percentfirstpt;
										}
										//First Quarter Quarterly Exam
										$myQEcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='Second' AND tbl_major_exam.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.SecCode='".$_SESSION['SecCode']."' AND tbl_major_exam.SYCode='".$_SESSION['year']."' AND tbl_major_exam.SchoolID='".$_SESSION['SchoolID']."' AND tbl_major_exam.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstQEscore=mysqli_fetch_array($myQEcore))
										{
										$firsttotalQEscore=$firsttotalQEscore +	$rowfirstQEscore['Score'];
										}
										
										//Calculate firstwwps
										if ($noQE['ItemNo']<>0)
										{
										$firstQEps=($firsttotalQEscore/$noQE['ItemNo'])*100;
										$firstQEws=$firstQEps*$percentfirstQE;
										}
										//Initial Grades
										$firstqaurterInitialGrade=$firstwwws+$firstptws+$firstQEws;
										
										//First Quarter Grade
										if ($firstqaurterInitialGrade>="99.99"){$FirstQuarterGrade="100";}elseif ($firstqaurterInitialGrade>="98.39" AND $firstqaurterInitialGrade<="99.98"){$FirstQuarterGrade="99";}elseif ($firstqaurterInitialGrade>='96.79' AND $firstqaurterInitialGrade<='98.38')
										{$FirstQuarterGrade='98';}elseif ($firstqaurterInitialGrade>='95.19' AND $firstqaurterInitialGrade<='96.78'){$FirstQuarterGrade='97';}elseif ($firstqaurterInitialGrade>='93.59' AND $firstqaurterInitialGrade<='95.18')
										{$FirstQuarterGrade='96';}elseif ($firstqaurterInitialGrade>='91.99' AND $firstqaurterInitialGrade<='93.58'){$FirstQuarterGrade='95';}elseif ($firstqaurterInitialGrade>='90.39' AND $firstqaurterInitialGrade<='91.98')
										{$FirstQuarterGrade='94';}elseif ($firstqaurterInitialGrade>='88.79' AND $firstqaurterInitialGrade<='90.38'){$FirstQuarterGrade='93';}elseif ($firstqaurterInitialGrade>='87.19' AND $firstqaurterInitialGrade<='88.78')
										{$FirstQuarterGrade='92';}elseif ($firstqaurterInitialGrade>='85.59' AND $firstqaurterInitialGrade<='87.18'){$FirstQuarterGrade='91';}elseif ($firstqaurterInitialGrade>='83.99' AND $firstqaurterInitialGrade<='85.59')
										{$FirstQuarterGrade='90';}elseif ($firstqaurterInitialGrade>='82.39' AND $firstqaurterInitialGrade<='83.98'){$FirstQuarterGrade='89';}elseif ($firstqaurterInitialGrade>='80.79' AND $firstqaurterInitialGrade<='82.38')
										{$FirstQuarterGrade='88';}elseif ($firstqaurterInitialGrade>='79.19' AND $firstqaurterInitialGrade<='80.78'){$FirstQuarterGrade='87';}elseif ($firstqaurterInitialGrade>='77.59' AND $firstqaurterInitialGrade<='79.18')
										{$FirstQuarterGrade='86';}elseif ($firstqaurterInitialGrade>='75.99' AND $firstqaurterInitialGrade<='77.58'){$FirstQuarterGrade='85';}elseif ($firstqaurterInitialGrade>='74.39' AND $firstqaurterInitialGrade<='75.98')
										{$FirstQuarterGrade='84';}elseif ($firstqaurterInitialGrade>='72.79' AND $firstqaurterInitialGrade<='74.38'){$FirstQuarterGrade='83';}elseif ($firstqaurterInitialGrade>='71.19' AND $firstqaurterInitialGrade<='72.78')
										{$FirstQuarterGrade='82';}elseif ($firstqaurterInitialGrade>='69.59' AND $firstqaurterInitialGrade<='71.18'){$FirstQuarterGrade='81';}elseif ($firstqaurterInitialGrade>='67.99' AND $firstqaurterInitialGrade<='69.58')
										{$FirstQuarterGrade='80';}elseif ($firstqaurterInitialGrade>='66.39' AND $firstqaurterInitialGrade<='67.98'){$FirstQuarterGrade='79';}elseif ($firstqaurterInitialGrade>='64.79' AND $firstqaurterInitialGrade<='66.38')
										{$FirstQuarterGrade='78';}elseif ($firstqaurterInitialGrade>='63.19' AND $firstqaurterInitialGrade<='64.78'){$FirstQuarterGrade='77';}elseif ($firstqaurterInitialGrade>='61.59' AND $firstqaurterInitialGrade<='63.18')
										{$FirstQuarterGrade='76';}elseif ($firstqaurterInitialGrade>='59.99' AND $firstqaurterInitialGrade<='61.58'){$FirstQuarterGrade='75';}elseif ($firstqaurterInitialGrade>='55.99' AND $firstqaurterInitialGrade<='59.98')
										{$FirstQuarterGrade='74';}elseif ($firstqaurterInitialGrade>='51.99' AND $firstqaurterInitialGrade<='55.98'){$FirstQuarterGrade='73';}elseif ($firstqaurterInitialGrade>='47.99' AND $firstqaurterInitialGrade<='51.98')
										{$FirstQuarterGrade='72';}elseif ($firstqaurterInitialGrade>='43.99' AND $firstqaurterInitialGrade<='47.98'){$FirstQuarterGrade='71';}elseif ($firstqaurterInitialGrade>='39.99' AND $firstqaurterInitialGrade<='43.98')
										{$FirstQuarterGrade='70';}elseif ($firstqaurterInitialGrade>='35.99' AND $firstqaurterInitialGrade<='39.98'){$FirstQuarterGrade='69';}elseif ($firstqaurterInitialGrade>='31.99' AND $firstqaurterInitialGrade<='735.98')
										{$FirstQuarterGrade='68';}elseif ($firstqaurterInitialGrade>='27.99' AND $firstqaurterInitialGrade<='31.98'){$FirstQuarterGrade='67';}elseif ($firstqaurterInitialGrade>='23.99' AND $firstqaurterInitialGrade<='27.98')
										{$FirstQuarterGrade='66';}elseif ($firstqaurterInitialGrade>='19.99' AND $firstqaurterInitialGrade<='23.98'){$FirstQuarterGrade='65';}elseif ($firstqaurterInitialGrade>='15.99' AND $firstqaurterInitialGrade<='19.98')
										{$FirstQuarterGrade='64';}elseif ($firstqaurterInitialGrade>='11.99' AND $firstqaurterInitialGrade<='15.98'){$FirstQuarterGrade='63';}elseif ($firstqaurterInitialGrade>='7.99' AND $firstqaurterInitialGrade<='11.98')
										{$FirstQuarterGrade='62';}elseif ($firstqaurterInitialGrade>='3.99' AND $firstqaurterInitialGrade<='7.98'){$FirstQuarterGrade='61';}elseif ($firstqaurterInitialGrade>='0' AND $firstqaurterInitialGrade<='3.98'){$FirstQuarterGrade='60';}
										
										//First Quarter Remarks
										if ($FirstQuarterGrade>=89){$remarks="Outstanding";}elseif ($FirstQuarterGrade>=84 AND $FirstQuarterGrade<=88)
										{$remarks="Very Satisfactory";}elseif ($FirstQuarterGrade>=79 AND $FirstQuarterGrade<=83){$remarks="Satisfactory";
										}elseif ($FirstQuarterGrade>=74 AND $FirstQuarterGrade<=78){$remarks="Fairly Satisfactory";}elseif ($FirstQuarterGrade>=59 AND $FirstQuarterGrade<=73){$remarks="Did Not Meet Expectations";}
										
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$firsttotalwwscore.'</td>
												<td style="text-align:center;">'.number_format($firstwwps,2).'</td>
												<td style="text-align:center;">'.number_format($firstwwws,2).'</td>
												<td style="text-align:center;">'.$firsttotalptscore.'</td>
												<td style="text-align:center;">'.number_format($firstptps,2).'</td>
												<td style="text-align:center;">'.number_format($firstptws,2).'</td>
												<td style="text-align:center;">'.$firsttotalQEscore.'</td>
												<td style="text-align:center;">'.number_format($firstQEps,2).'</td>
												<td style="text-align:center;">'.number_format($firstQEws,2).'</td>
												<td style="text-align:center;">'.number_format($firstqaurterInitialGrade,2).'</td>
												<td style="text-align:center;">'.number_format($FirstQuarterGrade,0).'</td>
												<td style="text-align:center;">'.$remarks.'</td>
												
											 </tr>';
									}  
									  ?> 
									   
									 </tbody>
									 
								</table>
							  
							 </div>
							 </div>
							 </div>
							 </div>
							  
							  </div>
							  
							  
							  
							  <div class="tab-pane fade" id="third"><br/>
								  <div class="tab-content">
									<div class="tab-pane fade in active" id="third">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#thirdWW" data-toggle="tab"> WRITTEN WORKS</a>
										</li>
										<li>
											<a href="#thirdPT" data-toggle="tab"> PERFORMANCE TASK</a>
										</li>
										<li >
											<a href="#thirdQE" data-toggle="tab"> QUARTER EXAM</a>
										</li>
										 <li >
											<a href="#thirdGrade" data-toggle="tab"> GRADE SHEET</a>
										</li>
									</ul>
										<div class="tab-content">
											<?php
							
							 echo '<div class="tab-pane fade in active" id="thirdWW">
							 <h4 class="page-header">THIRD QUARTER WRITTEN WORK</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="13" width="70%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
											
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >1</th>
											<th style="text-align:center;" >2</th>
											<th style="text-align:center;" >3</th>
											<th style="text-align:center;" >4</th>
											<th style="text-align:center;" >5</th>
											<th style="text-align:center;" >6</th>
											<th style="text-align:center;" >7</th>
											<th style="text-align:center;" >8</th>
											<th style="text-align:center;" >9</th>
											<th style="text-align:center;" >10</th>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										$totalThirdItemww=$no=$activ=0;
										 
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'Third' AND activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
										$no=mysqli_num_rows($mywwitem);
										echo '<tr>';
										
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										 echo '<th style="text-align:center;">'.$rowww['ItemNo'].'</th>';
										 $totalThirdItemww= $totalThirdItemww + $rowww['ItemNo'];
										 $activ++;
										}
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$totalThirdItemww.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
										</tr>';
                                     ?>
									 </thead>
									 <tbody>
									 <?php
									 $no=$percentthirdww=0;
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
										$percentthirdww=$perData['Written']/100;
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$totalThirdscore=$mythirdps=$thirdws=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Third' AND tbl_written_work_set_activity.activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."'  AND Grade_Level='".$_SESSION['Grade']."' AND tbl_written_work_set_activity.Quarter='Third' AND activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Third' AND tbl_written_work_set_activity.activity_remark='RECORDED' ORDER BY tbl_written_work_set_activity.QCode Asc");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$totalThirdscore = $totalThirdscore + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Third' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($totalThirdscore<>0)
												{
												$mythirdps=($totalThirdscore/$totalThirdItemww)*100;
												$thirdws=$mythirdps*$percentthirdww;
												}
												echo '<td style="text-align:center;">'.$totalThirdscore.'</td>';
												echo '<td style="text-align:center;">'.number_format($mythirdps,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($thirdws,2).'</td>';
												echo '<td style="text-align:center;"><a href="updatewritten.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Third')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
									  ?> 
									   
									 </tbody>
								    </table>		
									</div>
									 <div class="tab-pane fade" id="thirdPT">
									 <a href="#thirdptactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Performance Activity Item</a>
							
								  <?php
									echo '
								 <h4 class="page-header">THIRD QUARTER PERFORMANCE TASK</h4>
									
									<table width="100%" class="table table-striped table-bordered table-hover">		  
										 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="13" width="70%" style="text-align:center;">PERFORMANCE TASK <br/>['.$perData['Performance_task'].' %]</th>
											
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >1</th>
											<th style="text-align:center;" >2</th>
											<th style="text-align:center;" >3</th>
											<th style="text-align:center;" >4</th>
											<th style="text-align:center;" >5</th>
											<th style="text-align:center;" >6</th>
											<th style="text-align:center;" >7</th>
											<th style="text-align:center;" >8</th>
											<th style="text-align:center;" >9</th>
											<th style="text-align:center;" >10</th>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										$TotalThirdItemPT=$no=0;
										$myfristperformance=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."' AND Quarter ='Third' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' AND activity_remark='RECORDED' ORDER BY Date_created Asc");
										$no=mysqli_num_rows($myfristperformance);
										echo '<tr>';
										while($rowperform=mysqli_fetch_array($myfristperformance))
										{
											echo '<th style="text-align:center;" >'.$rowperform['ItemNo'].'</th>';
											$TotalThirdItemPT=$TotalThirdItemPT+$rowperform['ItemNo'];
										}	
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$TotalThirdItemPT.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>										
										  </tr>';
										?>
										</thead>
										<tbody>
										<?php
										 $no=$percentthirdpt=0;
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
										
										$percentthirdpt=$perData['Performance_task']/100;
										
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$totalthirdscorePT=$mythirdpsPT=$thirdwsPT=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Third' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."'  AND Grade='".$_SESSION['Grade']."' AND tbl_performance_task.Quarter='Third' AND activity_remark='RECORDED' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' ORDER BY Date_created Asc");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Third' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$totalthirdscorePT = $totalthirdscorePT + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Third' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($TotalThirdItemPT<>0)
												{
												$mythirdpsPT=($totalthirdscorePT/$TotalThirdItemPT)*100;
												$thirdwsPT=$mythirdpsPT*$percentthirdpt;
												}
												echo '<td style="text-align:center;">'.$totalthirdscorePT.'</td>';
												echo '<td style="text-align:center;">'.number_format($mythirdpsPT,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($thirdwsPT,2).'</td>';
												echo '<td style="text-align:center;"><a href="updateperfomance.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Third')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
									?>	
										</tbody>
										</table>
							   
									 </div>
									
									 <div class="tab-pane fade" id="thirdQE">
									   <?php
							   $myQEitemNo=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Third' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
								$noQEItem=mysqli_fetch_assoc($myQEitemNo);
								if ($noQEItem['ItemNo']=="")
								{
								echo '<a href="#thirdqeactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Quarter Exam Activity Item</a>';		
							    }
								echo '
							 <h4 class="page-header">THIRD QUARTERLY EXAM</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" >Learner\'s Name</th>
											<th  colspan="4"width="10%" style="text-align:center;">QUARTERLY EXAM<br/>['.$perData['Major_Exam'].' %]</th>
											
										</tr>
										<tr>
											<th style="text-align:center;width:10%;" >1</th>	
											<th width="10%" style="text-align:center;" >TOTAL</th>
											<th width="10%" style="text-align:center;" >PS</th>
											<th width="10%" style="text-align:center;" >WS</th>												
										</tr>
										<tr>
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >100</th>										
											<th style="text-align:center;" >'.$perData['Major_Exam'].'</th>	
																					
										</tr>
										</thead>
										<tbody>';
										
										 $no=$percentThirdQE=0;
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
												$percentThirdQE=$perData['Major_Exam']/100;
											while($data=mysqli_fetch_array($myinfo))
											{
												$no++;
												$mythirQEps=$thirdwsQE=0;
												$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='Third' ORDER BY tbl_major_exam.Date_created Asc LIMIT 1");
												$QEscore=mysqli_fetch_assoc($myscore);
												
												//PT and WS
												if ($QEscore['Score']<>0)
												{
												$mythirQEps=($QEscore['Score']/$noQEItem['ItemNo'])*100;
												$thirdwsQE=$mythirQEps*$percentThirdQE;
												}
											echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.number_format($mythirQEps,2).'</td>
												<td style="text-align:center;">'.number_format($thirdwsQE,2).'</td>
												<td style="text-align:center;"><a href="updateQuarterExam.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Third')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>
												
												</tr>';
											}	
										?>
										</tbody>
										</table>
							  
									 </div>
									
									 <div class="tab-pane fade" id="thirdGrade">
									 <a href="print_grade" class="btn btn-primary" style="float:right;" target="_blank">PRINT GRADE SHEET</a>
								<h4 class="page-header">THIRD QUARTER GRADE SHEET</h4>
								<?php
								echo '<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="3" width="15%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">PERFORMANCE TASKS <br/> ['.$perData['Performance_task'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">QUARTERLY ASSESSMENT <br/>['.$perData['Major_Exam'].' %]</th>
											<th rowspan="2" width="15%" style="text-align:center;">INITIAL GRADE</th>
											<th rowspan="2" width="15%" style="text-align:center;">QUARTERLY GRADE</th>
											<th rowspan="3" width="15%" style="text-align:center;">DESCRIPTION</th>
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
											
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										//Written Work Scoring Information
										$totalItem=$no=$nopt=$totalPTItem=0;
										$percentfirstww=$perData['Written']/100;
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'Third' AND activity_remark='RECORDED'");
										$no=mysqli_num_rows($mywwitem);
										
										//Performance Task	Scoring Information	
										$percentfirstpt=$perData['Performance_task']/100;
										$myptitem=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Third' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND activity_remark='RECORDED' AND Grade ='".$_SESSION['Grade']."'ORDER BY Date_created Asc");
										$nopt=mysqli_num_rows($myptitem);
										
										//Quarterly Exam	Scoring Information	
										$percentfirstQE=$perData['Major_Exam']/100;
										$myQEitem=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Third' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
										$noQE=mysqli_fetch_assoc($myQEitem);
										
										echo '<tr>';
										//Total Number of WRITTEN work Item
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										
										 $totalItem= $totalItem + $rowww['ItemNo'];
										
										}
											//Total Number of Performance Task Item
										while($rowpt=mysqli_fetch_array($myptitem))	
										{
										
										 $totalPTItem= $totalPTItem + $rowpt['ItemNo'];
										
										}
										echo '<th style="text-align:center;">'.$totalItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
											<th style="text-align:center;">'.$totalPTItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>
											<th style="text-align:center;">'.$noQE['ItemNo'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Major_Exam'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">100</th>
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
										$no++;
										$remarks="";
										$firsttotalwwscore=$firstwwps=$firstwwws=0;
										$firsttotalptscore=$firstptps=$firstptws=0;
										$firsttotalQEscore=$firstQEps=$firstQEws=0;
										$firstqaurterInitialGrade=$FirstQuarterGrade=0;
										//First Quarter Written Work
										$mywwscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Third' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
										while($rowfirstscore=mysqli_fetch_array($mywwscore))
										{
										$firsttotalwwscore=$firsttotalwwscore+	$rowfirstscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalItem<>0)
										{
										$firstwwps=($firsttotalwwscore/$totalItem)*100;
										$firstwwws=$firstwwps*$percentfirstww;
										}
										//First Quarter Performance Task
										$myPTcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Third' AND tbl_performance_task.activity_remark='RECORDED' AND tbl_performance_task.SecCode='".$_SESSION['SecCode']."' AND tbl_performance_task.SYCode='".$_SESSION['year']."' AND tbl_performance_task.SchoolID='".$_SESSION['SchoolID']."' AND tbl_performance_task.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstptscore=mysqli_fetch_array($myPTcore))
										{
										$firsttotalptscore=$firsttotalptscore +	$rowfirstptscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalPTItem<>0)
										{
										$firstptps=($firsttotalptscore/$totalPTItem)*100;
										$firstptws=$firstptps*$percentfirstpt;
										}
										//First Quarter Quarterly Exam
										$myQEcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='Third' AND tbl_major_exam.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.SecCode='".$_SESSION['SecCode']."' AND tbl_major_exam.SYCode='".$_SESSION['year']."' AND tbl_major_exam.SchoolID='".$_SESSION['SchoolID']."' AND tbl_major_exam.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstQEscore=mysqli_fetch_array($myQEcore))
										{
										$firsttotalQEscore=$firsttotalQEscore +	$rowfirstQEscore['Score'];
										}
										
										//Calculate firstwwps
										if ($noQE['ItemNo']<>0)
										{
										$firstQEps=($firsttotalQEscore/$noQE['ItemNo'])*100;
										$firstQEws=$firstQEps*$percentfirstQE;
										}
										//Initial Grades
										$firstqaurterInitialGrade=$firstwwws+$firstptws+$firstQEws;
										
										//First Quarter Grade
										if ($firstqaurterInitialGrade>="99.99"){$FirstQuarterGrade="100";}elseif ($firstqaurterInitialGrade>="98.39" AND $firstqaurterInitialGrade<="99.98"){$FirstQuarterGrade="99";}elseif ($firstqaurterInitialGrade>='96.79' AND $firstqaurterInitialGrade<='98.38')
										{$FirstQuarterGrade='98';}elseif ($firstqaurterInitialGrade>='95.19' AND $firstqaurterInitialGrade<='96.78'){$FirstQuarterGrade='97';}elseif ($firstqaurterInitialGrade>='93.59' AND $firstqaurterInitialGrade<='95.18')
										{$FirstQuarterGrade='96';}elseif ($firstqaurterInitialGrade>='91.99' AND $firstqaurterInitialGrade<='93.58'){$FirstQuarterGrade='95';}elseif ($firstqaurterInitialGrade>='90.39' AND $firstqaurterInitialGrade<='91.98')
										{$FirstQuarterGrade='94';}elseif ($firstqaurterInitialGrade>='88.79' AND $firstqaurterInitialGrade<='90.38'){$FirstQuarterGrade='93';}elseif ($firstqaurterInitialGrade>='87.19' AND $firstqaurterInitialGrade<='88.78')
										{$FirstQuarterGrade='92';}elseif ($firstqaurterInitialGrade>='85.59' AND $firstqaurterInitialGrade<='87.18'){$FirstQuarterGrade='91';}elseif ($firstqaurterInitialGrade>='83.99' AND $firstqaurterInitialGrade<='85.59')
										{$FirstQuarterGrade='90';}elseif ($firstqaurterInitialGrade>='82.39' AND $firstqaurterInitialGrade<='83.98'){$FirstQuarterGrade='89';}elseif ($firstqaurterInitialGrade>='80.79' AND $firstqaurterInitialGrade<='82.38')
										{$FirstQuarterGrade='88';}elseif ($firstqaurterInitialGrade>='79.19' AND $firstqaurterInitialGrade<='80.78'){$FirstQuarterGrade='87';}elseif ($firstqaurterInitialGrade>='77.59' AND $firstqaurterInitialGrade<='79.18')
										{$FirstQuarterGrade='86';}elseif ($firstqaurterInitialGrade>='75.99' AND $firstqaurterInitialGrade<='77.58'){$FirstQuarterGrade='85';}elseif ($firstqaurterInitialGrade>='74.39' AND $firstqaurterInitialGrade<='75.98')
										{$FirstQuarterGrade='84';}elseif ($firstqaurterInitialGrade>='72.79' AND $firstqaurterInitialGrade<='74.38'){$FirstQuarterGrade='83';}elseif ($firstqaurterInitialGrade>='71.19' AND $firstqaurterInitialGrade<='72.78')
										{$FirstQuarterGrade='82';}elseif ($firstqaurterInitialGrade>='69.59' AND $firstqaurterInitialGrade<='71.18'){$FirstQuarterGrade='81';}elseif ($firstqaurterInitialGrade>='67.99' AND $firstqaurterInitialGrade<='69.58')
										{$FirstQuarterGrade='80';}elseif ($firstqaurterInitialGrade>='66.39' AND $firstqaurterInitialGrade<='67.98'){$FirstQuarterGrade='79';}elseif ($firstqaurterInitialGrade>='64.79' AND $firstqaurterInitialGrade<='66.38')
										{$FirstQuarterGrade='78';}elseif ($firstqaurterInitialGrade>='63.19' AND $firstqaurterInitialGrade<='64.78'){$FirstQuarterGrade='77';}elseif ($firstqaurterInitialGrade>='61.59' AND $firstqaurterInitialGrade<='63.18')
										{$FirstQuarterGrade='76';}elseif ($firstqaurterInitialGrade>='59.99' AND $firstqaurterInitialGrade<='61.58'){$FirstQuarterGrade='75';}elseif ($firstqaurterInitialGrade>='55.99' AND $firstqaurterInitialGrade<='59.98')
										{$FirstQuarterGrade='74';}elseif ($firstqaurterInitialGrade>='51.99' AND $firstqaurterInitialGrade<='55.98'){$FirstQuarterGrade='73';}elseif ($firstqaurterInitialGrade>='47.99' AND $firstqaurterInitialGrade<='51.98')
										{$FirstQuarterGrade='72';}elseif ($firstqaurterInitialGrade>='43.99' AND $firstqaurterInitialGrade<='47.98'){$FirstQuarterGrade='71';}elseif ($firstqaurterInitialGrade>='39.99' AND $firstqaurterInitialGrade<='43.98')
										{$FirstQuarterGrade='70';}elseif ($firstqaurterInitialGrade>='35.99' AND $firstqaurterInitialGrade<='39.98'){$FirstQuarterGrade='69';}elseif ($firstqaurterInitialGrade>='31.99' AND $firstqaurterInitialGrade<='735.98')
										{$FirstQuarterGrade='68';}elseif ($firstqaurterInitialGrade>='27.99' AND $firstqaurterInitialGrade<='31.98'){$FirstQuarterGrade='67';}elseif ($firstqaurterInitialGrade>='23.99' AND $firstqaurterInitialGrade<='27.98')
										{$FirstQuarterGrade='66';}elseif ($firstqaurterInitialGrade>='19.99' AND $firstqaurterInitialGrade<='23.98'){$FirstQuarterGrade='65';}elseif ($firstqaurterInitialGrade>='15.99' AND $firstqaurterInitialGrade<='19.98')
										{$FirstQuarterGrade='64';}elseif ($firstqaurterInitialGrade>='11.99' AND $firstqaurterInitialGrade<='15.98'){$FirstQuarterGrade='63';}elseif ($firstqaurterInitialGrade>='7.99' AND $firstqaurterInitialGrade<='11.98')
										{$FirstQuarterGrade='62';}elseif ($firstqaurterInitialGrade>='3.99' AND $firstqaurterInitialGrade<='7.98'){$FirstQuarterGrade='61';}elseif ($firstqaurterInitialGrade>='0' AND $firstqaurterInitialGrade<='3.98'){$FirstQuarterGrade='60';}
										
										//First Quarter Remarks
										if ($FirstQuarterGrade>=89){$remarks="Outstanding";}elseif ($FirstQuarterGrade>=84 AND $FirstQuarterGrade<=88)
										{$remarks="Very Satisfactory";}elseif ($FirstQuarterGrade>=79 AND $FirstQuarterGrade<=83){$remarks="Satisfactory";
										}elseif ($FirstQuarterGrade>=74 AND $FirstQuarterGrade<=78){$remarks="Fairly Satisfactory";}elseif ($FirstQuarterGrade>=59 AND $FirstQuarterGrade<=73){$remarks="Did Not Meet Expectations";}
										
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$firsttotalwwscore.'</td>
												<td style="text-align:center;">'.number_format($firstwwps,2).'</td>
												<td style="text-align:center;">'.number_format($firstwwws,2).'</td>
												<td style="text-align:center;">'.$firsttotalptscore.'</td>
												<td style="text-align:center;">'.number_format($firstptps,2).'</td>
												<td style="text-align:center;">'.number_format($firstptws,2).'</td>
												<td style="text-align:center;">'.$firsttotalQEscore.'</td>
												<td style="text-align:center;">'.number_format($firstQEps,2).'</td>
												<td style="text-align:center;">'.number_format($firstQEws,2).'</td>
												<td style="text-align:center;">'.number_format($firstqaurterInitialGrade,2).'</td>
												<td style="text-align:center;">'.number_format($FirstQuarterGrade,0).'</td>
												<td style="text-align:center;">'.$remarks.'</td>
												
											 </tr>';
									}  
									  ?> 
									   
									 </tbody>
									 
								</table>
							  
									 
									 
									 </div>
									 
									</div>	
								 </div>	
								</div>	
								</div>	
							  <div class="tab-pane fade" id="fourth"><br/>
								<div class="tab-content">
									<div class="tab-pane fade in active" id="fourth">
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#fourthWW" data-toggle="tab"> WRITTEN WORKS</a>
										</li>
										<li>
											<a href="#fourthPT" data-toggle="tab"> PERFORMANCE TASK</a>
										</li>
										<li >
											<a href="#fourthQE" data-toggle="tab"> QUARTER EXAM</a>
										</li>
										 <li >
											<a href="#fourthGrade" data-toggle="tab"> GRADE SHEET</a>
										</li>
									</ul>
									
									<div class="tab-content">
									<?php
							
							 echo '<div class="tab-pane fade in active" id="fourthWW">
							 <h4 class="page-header">FOURTH QUARTER WRITTEN WORK</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="13" width="70%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
											
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >1</th>
											<th style="text-align:center;" >2</th>
											<th style="text-align:center;" >3</th>
											<th style="text-align:center;" >4</th>
											<th style="text-align:center;" >5</th>
											<th style="text-align:center;" >6</th>
											<th style="text-align:center;" >7</th>
											<th style="text-align:center;" >8</th>
											<th style="text-align:center;" >9</th>
											<th style="text-align:center;" >10</th>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										$totalFourthItemww=$no=$activ=0;
										 
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'Fourth' AND activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
										$no=mysqli_num_rows($mywwitem);
										echo '<tr>';
										
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										 echo '<th style="text-align:center;">'.$rowww['ItemNo'].'</th>';
										 $totalFourthItemww= $totalFourthItemww + $rowww['ItemNo'];
										 $activ++;
										}
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$totalFourthItemww.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
										</tr>';
                                     ?>
									 </thead>
									 <tbody>
									 <?php
									 $no=$Fourthpercentww=0;
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
										$Fourthpercentww=$perData['Written']/100;
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$Fourthtotalscoreww=$Fourthmypsww=$fourthwsww=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Fourth' AND tbl_written_work_set_activity.activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."'  AND Grade_Level='".$_SESSION['Grade']."' AND tbl_written_work_set_activity.Quarter='Fourth' AND activity_remark='RECORDED'  ORDER BY tbl_written_work_set_activity.QCode Asc");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Fourth' AND tbl_written_work_set_activity.activity_remark='RECORDED' ORDER BY tbl_written_work_set_activity.QCode Asc");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$Fourthtotalscoreww = $Fourthtotalscoreww + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Fourth' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($Fourthtotalscoreww<>0)
												{
												$Fourthmypsww=($Fourthtotalscoreww/$totalFourthItemww)*100;
												$fourthwsww=$Fourthmypsww*$Fourthpercentww;
												}
												echo '<td style="text-align:center;">'.$Fourthtotalscoreww.'</td>';
												echo '<td style="text-align:center;">'.number_format($Fourthmypsww,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($fourthwsww,2).'</td>';
												echo '<td style="text-align:center;"><a href="updatewritten.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Fourth')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
									  ?> 
									   
									 </tbody>
								    </table>		
									</div>
									 <div class="tab-pane fade" id="fourthPT">
									  <a href="#fourthptactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Performance Activity Item</a>
							
								  <?php
									echo '
								 <h4 class="page-header">FOURTH QUARTER PERFORMANCE TASK</h4>
									
									<table width="100%" class="table table-striped table-bordered table-hover">		  
										 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="13" width="70%" style="text-align:center;">PERFORMANCE TASK <br/>['.$perData['Performance_task'].' %]</th>
											
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >1</th>
											<th style="text-align:center;" >2</th>
											<th style="text-align:center;" >3</th>
											<th style="text-align:center;" >4</th>
											<th style="text-align:center;" >5</th>
											<th style="text-align:center;" >6</th>
											<th style="text-align:center;" >7</th>
											<th style="text-align:center;" >8</th>
											<th style="text-align:center;" >9</th>
											<th style="text-align:center;" >10</th>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										$TotalFourthItemPT=$no=0;
										$myfristperformance=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."' AND Quarter ='Fourth' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' AND activity_remark='RECORDED' ORDER BY Date_created Asc");
										$no=mysqli_num_rows($myfristperformance);
										echo '<tr>';
										while($rowperform=mysqli_fetch_array($myfristperformance))
										{
											echo '<th style="text-align:center;" >'.$rowperform['ItemNo'].'</th>';
											$TotalFourthItemPT=$TotalFourthItemPT+$rowperform['ItemNo'];
										}	
										while($no< 10)
												{
											     $no++;
												 echo '<td style="text-align:center;">0</td>';
												 
												}
										echo '<th style="text-align:center;">'.$TotalFourthItemPT.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>										
										  </tr>';
										?>
										</thead>
										<tbody>
										<?php
										 $no=$percentfourthpt=0;
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
										
										$percentfourthpt=$perData['Performance_task']/100;
										
									while($data=mysqli_fetch_array($myinfo))
									{
										$no++;
										$totalfourthscorePT=$myfourthpsPT=$fourthwsPT=$myscor=$num=0;
										$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Fourth' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
											
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>';
											
										if (mysqli_num_rows($myscore)==0)
											{
										
												 //No data record
												$myscore3=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_GET['SubCode']."'  AND Grade='".$_SESSION['Grade']."' AND tbl_performance_task.Quarter='Fourth' AND activity_remark='RECORDED' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' ORDER BY Date_created Asc");
										        while ($rowscore3=mysqli_fetch_assoc($myscore3))
												{ 
												   $num++;
												   
											   echo '<td style="text-align:center;">0</td>';
												   
												}
												while($num< 10)
											    {
											     $num++;
												  echo '<td style="text-align:center;">0</td>';
												}	
											}else{
												
												$ans=0;	
												$myscore1=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Fourth' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$ans=mysqli_num_rows($myscore1);										
												while ($rowscore=mysqli_fetch_assoc($myscore1))
												{
													$myscor++;
													
													echo '<td style="text-align:center;">'.$rowscore['Score'].'</td>';
													$totalfourthscorePT = $totalfourthscorePT + $rowscore['Score'];
												 											   
												}
												
												while($ans< 10)
												{
											     $ans++;
												 //No data record
												$myscore2=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Fourth' AND tbl_performance_task.activity_remark='RECORDED' ORDER BY tbl_performance_task.Date_created Asc");
												$rowscore2=mysqli_fetch_assoc($myscore2);
												 echo '<td style="text-align:center;">0</td>';
												 
												}
												
																							
											}
											  
												if ($TotalFourthItemPT<>0)
												{
												$myfourthpsPT=($totalfourthscorePT/$TotalFourthItemPT)*100;
												$fourthwsPT=$myfourthpsPT*$percentthirdpt;
												}
												echo '<td style="text-align:center;">'.$totalfourthscorePT.'</td>';
												echo '<td style="text-align:center;">'.number_format($myfourthpsPT,2).'</td>';
												echo '<td style="text-align:center;">'.number_format($fourthwsPT,2).'</td>';
												echo '<td style="text-align:center;"><a href="updateperfomance.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Fourth')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>';
												
												echo '</tr>';
									}  
									?>	
										</tbody>
										</table>
									 </div>
									
									 <div class="tab-pane fade" id="fourthQE">
									 <?php
							   $myQEitemNo=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Fourth' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
								$noQEItem=mysqli_fetch_assoc($myQEitemNo);
								if ($noQEItem['ItemNo']=="")
								{
								echo '<a href="#fourthqeactivity" style="float:right;" class="btn btn-info" data-toggle="modal">Add Quarter Exam Activity Item</a>';		
							    }
								echo '
							 <h4 class="page-header">FOURTH QUARTERLY EXAM</h4>
								
								<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" >Learner\'s Name</th>
											<th  colspan="4"width="10%" style="text-align:center;">QUARTERLY EXAM<br/>['.$perData['Major_Exam'].' %]</th>
											
										</tr>
										<tr>
											<th style="text-align:center;width:10%;" >1</th>	
											<th width="10%" style="text-align:center;" >TOTAL</th>
											<th width="10%" style="text-align:center;" >PS</th>
											<th width="10%" style="text-align:center;" >WS</th>												
										</tr>
										<tr>
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >'.$noQEItem['ItemNo'].'</th>										
											<th style="text-align:center;" >100</th>										
											<th style="text-align:center;" >'.$perData['Major_Exam'].'</th>	
																					
										</tr>
										</thead>
										<tbody>';
										
										 $no=$percentFourthQE=0;
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
												$percentFourthQE=$perData['Major_Exam']/100;
											while($data=mysqli_fetch_array($myinfo))
											{
												$no++;
												$myfourthQEps=$fourthwsQE=0;
												$myscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='Fourth' ORDER BY tbl_major_exam.Date_created Asc LIMIT 1");
												$QEscore=mysqli_fetch_assoc($myscore);
												
												//PT and WS
												if ($QEscore['Score']<>0)
												{
												$myfourthQEps=($QEscore['Score']/$noQEItem['ItemNo'])*100;
												$fourthwsQE=$myfourthQEps*$percentFourthQE;
												}
											echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.$QEscore['Score'].'</td>
												<td style="text-align:center;">'.number_format($myfourthQEps,2).'</td>
												<td style="text-align:center;">'.number_format($fourthwsQE,2).'</td>
												<td style="text-align:center;"><a href="updateQuarterExam.php?code='.urlencode(base64_encode($data['lrn'])).'&quart='.urlencode(base64_encode('Fourth')).'" data-toggle="modal" data-target="#updateww" title="View Learner\'s Score" style="padding:4px;margin:4px;" class="btn btn-info"><i class="fa fa-desktop fa-fw"></i></a></td>
												
												</tr>';
											}	
										?>
										</tbody>
										</table>
									 </div>
									
									 <div class="tab-pane fade" id="fourthGrade">
									  <a href="print_grade" class="btn btn-primary" style="float:right;" target="_blank">PRINT GRADE SHEET</a>
								<h4 class="page-header">FOURTH QUARTER GRADE SHEET</h4>
								<?php
								echo '<table width="100%" class="table table-striped table-bordered table-hover">		  
									 <thead>
										<tr>							
											<th rowspan="3" width="5%" style="text-align:center;">#</th>
											<th rowspan="3" width="20%">Learner\'s Name</th>
											<th colspan="3" width="15%" style="text-align:center;">WRITTEN WORK <br/>['.$perData['Written'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">PERFORMANCE TASKS <br/> ['.$perData['Performance_task'].' %]</th>
											<th colspan="3" width="15%" style="text-align:center;">QUARTERLY ASSESSMENT <br/>['.$perData['Major_Exam'].' %]</th>
											<th rowspan="2" width="15%" style="text-align:center;">INITIAL GRADE</th>
											<th rowspan="2" width="15%" style="text-align:center;">QUARTERLY GRADE</th>
											<th rowspan="3" width="15%" style="text-align:center;">DESCRIPTION</th>
										</tr>';
										?>
										<tr>
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
											
											
											<th style="text-align:center;" >TOTAL</th>
											<th style="text-align:center;" >PS</th>
											<th style="text-align:center;" >WS</th>
										</tr>
										<?php
										//Written Work Scoring Information
										$totalItem=$no=$nopt=$totalPTItem=0;
										$percentfirstww=$perData['Written']/100;
										$mywwitem=mysqli_query($con,"SELECT * FROM tbl_written_work_set_activity WHERE SubCode='".$_GET['SubCode']."' AND Grade_Level='".$_SESSION['Grade']."' AND Quarter = 'Fourth' AND activity_remark='RECORDED'");
										$no=mysqli_num_rows($mywwitem);
										
										//Performance Task	Scoring Information	
										$percentfirstpt=$perData['Performance_task']/100;
										$myptitem=mysqli_query($con,"SELECT * FROM tbl_performance_task WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Fourth' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND activity_remark='RECORDED' AND Grade ='".$_SESSION['Grade']."'ORDER BY Date_created Asc");
										$nopt=mysqli_num_rows($myptitem);
										
										//Quarterly Exam	Scoring Information	
										$percentfirstQE=$perData['Major_Exam']/100;
										$myQEitem=mysqli_query($con,"SELECT * FROM tbl_major_exam WHERE SubCode='".$_SESSION['SubCode']."' AND Quarter ='Fourth' AND SecCode='".$_SESSION['SecCode']."' AND SYCode='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' AND Grade ='".$_SESSION['Grade']."' ORDER BY Date_created Asc LIMIT 1");
										$noQE=mysqli_fetch_assoc($myQEitem);
										
										echo '<tr>';
										//Total Number of WRITTEN work Item
										while($rowww=mysqli_fetch_array($mywwitem))	
										{
										
										 $totalItem= $totalItem + $rowww['ItemNo'];
										
										}
											//Total Number of Performance Task Item
										while($rowpt=mysqli_fetch_array($myptitem))	
										{
										
										 $totalPTItem= $totalPTItem + $rowpt['ItemNo'];
										
										}
										echo '<th style="text-align:center;">'.$totalItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Written'].'</th>
											<th style="text-align:center;">'.$totalPTItem.'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Performance_task'].'</th>
											<th style="text-align:center;">'.$noQE['ItemNo'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">'.$perData['Major_Exam'].'</th>
											<th style="text-align:center;">100</th>
											<th style="text-align:center;">100</th>
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
										$no++;
										$remarks="";
										$firsttotalwwscore=$firstwwps=$firstwwws=0;
										$firsttotalptscore=$firstptps=$firstptws=0;
										$firsttotalQEscore=$firstQEps=$firstQEws=0;
										$firstqaurterInitialGrade=$FirstQuarterGrade=0;
										//First Quarter Written Work
										$mywwscore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_written_work_set_activity ON tbl_activity_learner_score.Activity_Code=tbl_written_work_set_activity.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_written_work_set_activity.Quarter='Fourth' AND tbl_written_work_set_activity.activity_remark='RECORDED'");
										while($rowfirstscore=mysqli_fetch_array($mywwscore))
										{
										$firsttotalwwscore=$firsttotalwwscore+	$rowfirstscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalItem<>0)
										{
										$firstwwps=($firsttotalwwscore/$totalItem)*100;
										$firstwwws=$firstwwps*$percentfirstww;
										}
										//First Quarter Performance Task
										$myPTcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_performance_task ON tbl_activity_learner_score.Activity_Code=tbl_performance_task.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_performance_task.Quarter='Fourth' AND tbl_performance_task.activity_remark='RECORDED' AND tbl_performance_task.SecCode='".$_SESSION['SecCode']."' AND tbl_performance_task.SYCode='".$_SESSION['year']."' AND tbl_performance_task.SchoolID='".$_SESSION['SchoolID']."' AND tbl_performance_task.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstptscore=mysqli_fetch_array($myPTcore))
										{
										$firsttotalptscore=$firsttotalptscore +	$rowfirstptscore['Score'];
										}
										
										//Calculate firstwwps
										if ($totalPTItem<>0)
										{
										$firstptps=($firsttotalptscore/$totalPTItem)*100;
										$firstptws=$firstptps*$percentfirstpt;
										}
										//First Quarter Quarterly Exam
										$myQEcore=mysqli_query($con,"SELECT * FROM tbl_activity_learner_score INNER JOIN tbl_major_exam ON tbl_activity_learner_score.Activity_Code=tbl_major_exam.QCode WHERE tbl_activity_learner_score.lrn='".$data['lrn']."' AND tbl_activity_learner_score.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.Quarter='Fourth' AND tbl_major_exam.SubCode='".$_GET['SubCode']."' AND tbl_major_exam.SecCode='".$_SESSION['SecCode']."' AND tbl_major_exam.SYCode='".$_SESSION['year']."' AND tbl_major_exam.SchoolID='".$_SESSION['SchoolID']."' AND tbl_major_exam.Grade ='".$_SESSION['Grade']."'");
										while($rowfirstQEscore=mysqli_fetch_array($myQEcore))
										{
										$firsttotalQEscore=$firsttotalQEscore +	$rowfirstQEscore['Score'];
										}
										
										//Calculate firstwwps
										if ($noQE['ItemNo']<>0)
										{
										$firstQEps=($firsttotalQEscore/$noQE['ItemNo'])*100;
										$firstQEws=$firstQEps*$percentfirstQE;
										}
										//Initial Grades
										$firstqaurterInitialGrade=$firstwwws+$firstptws+$firstQEws;
										
										//First Quarter Grade
										if ($firstqaurterInitialGrade>="99.99"){$FirstQuarterGrade="100";}elseif ($firstqaurterInitialGrade>="98.39" AND $firstqaurterInitialGrade<="99.98"){$FirstQuarterGrade="99";}elseif ($firstqaurterInitialGrade>='96.79' AND $firstqaurterInitialGrade<='98.38')
										{$FirstQuarterGrade='98';}elseif ($firstqaurterInitialGrade>='95.19' AND $firstqaurterInitialGrade<='96.78'){$FirstQuarterGrade='97';}elseif ($firstqaurterInitialGrade>='93.59' AND $firstqaurterInitialGrade<='95.18')
										{$FirstQuarterGrade='96';}elseif ($firstqaurterInitialGrade>='91.99' AND $firstqaurterInitialGrade<='93.58'){$FirstQuarterGrade='95';}elseif ($firstqaurterInitialGrade>='90.39' AND $firstqaurterInitialGrade<='91.98')
										{$FirstQuarterGrade='94';}elseif ($firstqaurterInitialGrade>='88.79' AND $firstqaurterInitialGrade<='90.38'){$FirstQuarterGrade='93';}elseif ($firstqaurterInitialGrade>='87.19' AND $firstqaurterInitialGrade<='88.78')
										{$FirstQuarterGrade='92';}elseif ($firstqaurterInitialGrade>='85.59' AND $firstqaurterInitialGrade<='87.18'){$FirstQuarterGrade='91';}elseif ($firstqaurterInitialGrade>='83.99' AND $firstqaurterInitialGrade<='85.59')
										{$FirstQuarterGrade='90';}elseif ($firstqaurterInitialGrade>='82.39' AND $firstqaurterInitialGrade<='83.98'){$FirstQuarterGrade='89';}elseif ($firstqaurterInitialGrade>='80.79' AND $firstqaurterInitialGrade<='82.38')
										{$FirstQuarterGrade='88';}elseif ($firstqaurterInitialGrade>='79.19' AND $firstqaurterInitialGrade<='80.78'){$FirstQuarterGrade='87';}elseif ($firstqaurterInitialGrade>='77.59' AND $firstqaurterInitialGrade<='79.18')
										{$FirstQuarterGrade='86';}elseif ($firstqaurterInitialGrade>='75.99' AND $firstqaurterInitialGrade<='77.58'){$FirstQuarterGrade='85';}elseif ($firstqaurterInitialGrade>='74.39' AND $firstqaurterInitialGrade<='75.98')
										{$FirstQuarterGrade='84';}elseif ($firstqaurterInitialGrade>='72.79' AND $firstqaurterInitialGrade<='74.38'){$FirstQuarterGrade='83';}elseif ($firstqaurterInitialGrade>='71.19' AND $firstqaurterInitialGrade<='72.78')
										{$FirstQuarterGrade='82';}elseif ($firstqaurterInitialGrade>='69.59' AND $firstqaurterInitialGrade<='71.18'){$FirstQuarterGrade='81';}elseif ($firstqaurterInitialGrade>='67.99' AND $firstqaurterInitialGrade<='69.58')
										{$FirstQuarterGrade='80';}elseif ($firstqaurterInitialGrade>='66.39' AND $firstqaurterInitialGrade<='67.98'){$FirstQuarterGrade='79';}elseif ($firstqaurterInitialGrade>='64.79' AND $firstqaurterInitialGrade<='66.38')
										{$FirstQuarterGrade='78';}elseif ($firstqaurterInitialGrade>='63.19' AND $firstqaurterInitialGrade<='64.78'){$FirstQuarterGrade='77';}elseif ($firstqaurterInitialGrade>='61.59' AND $firstqaurterInitialGrade<='63.18')
										{$FirstQuarterGrade='76';}elseif ($firstqaurterInitialGrade>='59.99' AND $firstqaurterInitialGrade<='61.58'){$FirstQuarterGrade='75';}elseif ($firstqaurterInitialGrade>='55.99' AND $firstqaurterInitialGrade<='59.98')
										{$FirstQuarterGrade='74';}elseif ($firstqaurterInitialGrade>='51.99' AND $firstqaurterInitialGrade<='55.98'){$FirstQuarterGrade='73';}elseif ($firstqaurterInitialGrade>='47.99' AND $firstqaurterInitialGrade<='51.98')
										{$FirstQuarterGrade='72';}elseif ($firstqaurterInitialGrade>='43.99' AND $firstqaurterInitialGrade<='47.98'){$FirstQuarterGrade='71';}elseif ($firstqaurterInitialGrade>='39.99' AND $firstqaurterInitialGrade<='43.98')
										{$FirstQuarterGrade='70';}elseif ($firstqaurterInitialGrade>='35.99' AND $firstqaurterInitialGrade<='39.98'){$FirstQuarterGrade='69';}elseif ($firstqaurterInitialGrade>='31.99' AND $firstqaurterInitialGrade<='735.98')
										{$FirstQuarterGrade='68';}elseif ($firstqaurterInitialGrade>='27.99' AND $firstqaurterInitialGrade<='31.98'){$FirstQuarterGrade='67';}elseif ($firstqaurterInitialGrade>='23.99' AND $firstqaurterInitialGrade<='27.98')
										{$FirstQuarterGrade='66';}elseif ($firstqaurterInitialGrade>='19.99' AND $firstqaurterInitialGrade<='23.98'){$FirstQuarterGrade='65';}elseif ($firstqaurterInitialGrade>='15.99' AND $firstqaurterInitialGrade<='19.98')
										{$FirstQuarterGrade='64';}elseif ($firstqaurterInitialGrade>='11.99' AND $firstqaurterInitialGrade<='15.98'){$FirstQuarterGrade='63';}elseif ($firstqaurterInitialGrade>='7.99' AND $firstqaurterInitialGrade<='11.98')
										{$FirstQuarterGrade='62';}elseif ($firstqaurterInitialGrade>='3.99' AND $firstqaurterInitialGrade<='7.98'){$FirstQuarterGrade='61';}elseif ($firstqaurterInitialGrade>='0' AND $firstqaurterInitialGrade<='3.98'){$FirstQuarterGrade='60';}
										
										//First Quarter Remarks
										if ($FirstQuarterGrade>=89){$remarks="Outstanding";}elseif ($FirstQuarterGrade>=84 AND $FirstQuarterGrade<=88)
										{$remarks="Very Satisfactory";}elseif ($FirstQuarterGrade>=79 AND $FirstQuarterGrade<=83){$remarks="Satisfactory";
										}elseif ($FirstQuarterGrade>=74 AND $FirstQuarterGrade<=78){$remarks="Fairly Satisfactory";}elseif ($FirstQuarterGrade>=59 AND $FirstQuarterGrade<=73){$remarks="Did Not Meet Expectations";}
										
										echo '<tr>
												<td style="text-align:center;">'.$no.'</td>
												<td>'.$data['Lname'].', '.$data['FName'].'</td>
												<td style="text-align:center;">'.$firsttotalwwscore.'</td>
												<td style="text-align:center;">'.number_format($firstwwps,2).'</td>
												<td style="text-align:center;">'.number_format($firstwwws,2).'</td>
												<td style="text-align:center;">'.$firsttotalptscore.'</td>
												<td style="text-align:center;">'.number_format($firstptps,2).'</td>
												<td style="text-align:center;">'.number_format($firstptws,2).'</td>
												<td style="text-align:center;">'.$firsttotalQEscore.'</td>
												<td style="text-align:center;">'.number_format($firstQEps,2).'</td>
												<td style="text-align:center;">'.number_format($firstQEws,2).'</td>
												<td style="text-align:center;">'.number_format($firstqaurterInitialGrade,2).'</td>
												<td style="text-align:center;">'.number_format($FirstQuarterGrade,0).'</td>
												<td style="text-align:center;">'.$remarks.'</td>
												
											 </tr>';
									}  
									  ?> 
									   
									 </tbody>
									 
								</table>
									 </div>
									 
									</div>
									
								 </div>	
								 
								 
								</div>	
							  </div>
							 
                             
				</div>




<!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="newpercent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	   <div class="modal-header">
         
          <h3 class="modal-title"><center>SET SUBJECT PERCENTAGE</center></h3>
		 
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<label>LEARNING AREAS </label>
		<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
		<?php
		
		echo '<label>WRITTEN WORK </label>
		<input type="text" name="ww" class="form-control" placeholder="Set written Work" value="'.$perData['Written'].'" required>
		<label>PERFORMANCE TASK </label>
		<input type="text" name="pt" class="form-control" placeholder="Set Performance Task" value="'.$perData['Performance_task'].'" required>
		<label>QUARTERLY EXAM </label>
		<input type="text" name="qe" class="form-control" placeholder="Set Quarterly Exam" value="'.$perData['Major_Exam'].'" required>';
		
		?>
		</div>
		<div class="modal-footer">
		<input type="submit" name="save_percent" value="SUBMIT" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	    </div>
		</form>
	</div>
	</div>
</div>
  </div>
					
					
					
<!-- First Quarter Activity-->
								<div class="panel-body">
															
												 <!-- Modal -->
									 <div class="modal fade" id="updateww" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
									 <div class="modal-dialog">
									
									  <!-- Modal content-->
									  <div class="modal-content">
									   
									</div>
									</div>
								</div>
								  </div>
									
														 
							
							<div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="firstptactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET PERFORMANCE TASK</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_first_performance" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							  <div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="newqeactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET QUARTERLY EXAMINATION</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_first_quarter" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							  
									<!-- End Firts Quarter Activity-->								
									<!--Second Quarter Activity-->								
							 
							 
							 <div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="secondptactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET PERFORMANCE TASK</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_second_performance" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							    <div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="secondqeactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET QUARTERLY EXAMINATION</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_second_quarter" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							  
							  <!-- End Second Quarter Activity-->	
							  
							  
							  
							  <!--Third Quarter Activity-->								
							 
							 
							 <div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="thirdptactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET PERFORMANCE TASK</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_third_performance" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							    <div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="thirdqeactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET QUARTERLY EXAMINATION</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_third_quarter" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							  
							  <!-- End Third Quarter Activity-->	
							  
							  
							    <!--Third Quarter Activity-->								
							 
							 
							 <div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="fourthptactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET PERFORMANCE TASK</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_fourth_performance" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							    <div class="panel-body">
														
											 <!-- Modal -->
								 <div class="modal fade" id="fourthqeactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
								 <div class="modal-dialog">
								
								  <!-- Modal content-->
								  <div class="modal-content">
								   <div class="modal-header">
									 
									  <h3 class="modal-title"><center>SET QUARTERLY EXAMINATION</center></h3>
									 
									</div>
									<form action="" Method="POST" enctype="multipart/form-data">
									<div class="modal-body">
									<label>LEARNING AREAS </label>
									<input type="text"  class="form-control" value="<?php echo $rowdata['LearningAreas'].' '.$_SESSION['Grade'];?>" disabled>
									<label style="text-transform:uppercase;">Name of Activity:</label>
									<input type="text" name="name_of_activity" class="form-control" placeholder="Name of Activity" required>
									<label style="text-transform:uppercase;">Number of Item:</label>
									<input type="number" name="number_of_item" class="form-control" placeholder="Number of Item" required>
									
									</div>
									<div class="modal-footer">
									<input type="submit" name="save_fourth_quarter" value="SUBMIT" class="btn btn-primary">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
								</div>
							</div>
							  </div>
							  
							  
							  <!-- End Third Quarter Activity-->	