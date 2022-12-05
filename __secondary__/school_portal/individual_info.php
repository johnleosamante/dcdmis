<?php
//Add Subject 
                    $_SESSION['lrn']=$_GET['l'];
					$_SESSION['Grade']=$_GET['Code'];
					
					
			   if (isset($_POST['change_section']))
					{
					
					mysqli_query($con,"UPDATE tbl_learners SET SecCode='".$_POST['newsection']."' WHERE lrn='".$_GET['l']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' AND Grade ='".$_GET['Code']."' LIMIT 1");	
						
											
						if(mysqli_affected_rows($con)==1)
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
					}elseif (isset($_POST['updatelrn']))
					{
					if ($_SESSION['Grade']=='11' ||$_SESSION['Grade']=='12')
					{
						if ($_SESSION['Sem']=='First Semester')
						{
						mysqli_query($con,"UPDATE first_semester SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' LIMIT 1");	
						}elseif ($_SESSION['Sem']=='Second Semester')
						{
						mysqli_query($con,"UPDATE second_semester SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' LIMIT 1");	
							
						}
						mysqli_query($con,"UPDATE tbl_shs_tor SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
					}else{
						mysqli_query($con,"UPDATE tbl_learners SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."' LIMIT 1");	
						
					mysqli_query($con,"UPDATE junior_tor SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."'");
					
					}
					mysqli_query($con,"UPDATE tbl_student SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
					mysqli_query($con,"UPDATE tbl_registration SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."'LIMIT 1");
					
					if(mysqli_affected_rows($con)==1)
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
					else  if (isset($_POST['changepass']))
					{
							$pass=md5($_POST['newpass']);
							$query=mysqli_query($con,"SELECT * FROM tbl_student_user WHERE username='".$_SESSION['lrn']."' AND SchoolID='".$_SESSION['school_id']."'");
							if (mysqli_num_rows($query)==0)
							{
							mysqli_query($con,"INSERT INTO tbl_student_user VALUES (NULL,'".$_SESSION['lrn']."','".$pass."','Active','".$_SESSION['Grade']."','".$_SESSION['school_id']."')");	
															   
							}else{
								mysqli_query($con,"UPDATE tbl_student_user SET password='".$pass."' WHERE username='".$_SESSION['lrn']."'AND SchoolID='".$_SESSION['school_id']."' LIMIT 1");
							}	
											
						if(mysqli_affected_rows($con)==1)
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
					}elseif (isset($_POST['tagasexaminee']))
					{
					
						$querydata=mysqli_query($con,"SELECT * FROM tbl_assessment WHERE SchoolID='".$_SESSION['school_id']."' AND LRN='".$_SESSION['lrn']."' AND School_Year='".$_SESSION['year']."'");
						if (mysqli_num_rows($querydata)==0)
						{
							mysqli_query($con,"INSERT INTO tbl_assessment VALUES(NULL,'".$_SESSION['school_id']."','".$_SESSION['lrn']."','Offline','".$_SESSION['year']."','".$_POST['type_of_exam']."')");
						}		
						if(mysqli_affected_rows($con)==1)
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
					elseif (isset($_POST['running']))
					{
						$run=mysqli_query($con,"SELECT * FROM tbl_ssg_officer WHERE GradeLevel='".$_SESSION['Grade']."' AND lrn ='".$_SESSION['lrn']."' AND Position='".$_POST['candidate']."' AND Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['school_id']."'");
						if (mysqli_num_rows($run)==0)
						{
							mysqli_query($con,"INSERT INTO tbl_ssg_officer VALUES(NULL,'".$_SESSION['lrn']."','".$_SESSION['Grade']."','".$_POST['candidate']."','".$_POST['party']."','0','".$_SESSION['year']."','Aspirant','".$_SESSION['school_id']."')");
						}
						if(mysqli_affected_rows($con)==1)
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

<style>
td,th,p{
	text-transform:uppercase;
}
</style>

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
					
					echo '	<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode($_GET['cat'])).'" style="float:right;" class="btn btn-secondary">Back</a>
					<h3>Learners Information</h3>';
					
					?>
					</div>
					<!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
						
					
					if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
							if ($_SESSION['Sem']=="First Semester")
								{
									
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND first_semester.Grade='".$_SESSION['Grade']."'ORDER BY tbl_student.Lname Asc");
												
								}
										
							elseif ($_SESSION['Sem']=="Second Semester")
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' AND second_semester.Grade='".$_SESSION['Grade']."'ORDER BY tbl_student.Lname Asc");
										
								}	
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");	
					}
					
					$data=mysqli_fetch_assoc($myinfo);
					
				
					if ($data['Picture']=="")
					{
					echo '<img src="../../pcdmis/logo/user.png" width="250" height="260" align="right">';	
					}else{
					echo '<img src="../../online-class/requirements/'.$data['Picture'].'" width="250" height="260" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
					$_SESSION['SecCode']=$data['SecCode'];
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
						{
							echo  '<p>Grade & Section: '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}else{
							echo  '<p>Grade & Section: Grade '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}
					$advice=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID =tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['SecCode']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."'");	
					$adv=mysqli_fetch_assoc($advice);
					echo  '<p>Adviser: '.$adv['Emp_LName'].', '.$adv['Emp_FName'].'</p>';
					echo  '<p>Date: '.$data['Date_enrolled'].'</p>
					
							<hr/>';
					echo '<h4>Subject Load</h4>
							';
					echo '<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th rowspan="2" width="5%">#</th>
									<th rowspan="2">Learning Areas</th>
									<th colspan="3" style="text-align:center;">Schedule</th>
									<th rowspan="2">Teacher</th>
									
								</tr>
								<tr>
									<th style="text-align:center;">Time</th>
									<th style="text-align:center;">Day</th>
									<th style="text-align:center;">Room</th>
								
									
								</tr>
							</thead>
							<tbody>';
							
							
							
							if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
							{
								$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND tbl_shs_tor.SecCode='".$_SESSION['SecCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode = '".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode = '".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							else{
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['school_id']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' AND class_program.SecCode = '".$_SESSION['SecCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							
							$no=0;							
							while($subrow=mysqli_fetch_array($mysubject))
							{
							$no++;	
							echo '<tr>
									<td>'.$no.'</td>
									<td>'.$subrow['LearningAreas'].'</td>
									<td>'.$subrow['SecTime'].'</td>
									<td>'.$subrow['SecDay'].'</td>
									<td>'.$subrow['SecDesc'].'</td>
									<td>'.$subrow['Emp_LName'].'</td>
									
								</tr>';
							}	
						echo '</tbody>
						</table>';
						
						
					?>
                            
                        </div>
						  <div class="panel-footer">
						  <a href="#changesection" data-toggle="modal" class="btn btn-warning">Change Section</a>
						  <a href="#resetaccount" data-toggle="modal" class="btn btn-danger">Reset Account</a>
						  <a href="#tagforexam" data-toggle="modal" class="btn btn-primary">Tag as Examinee</a>
						 <?php echo' <a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("form10")).'" class="btn btn-success">Form 10</a>';?>
						  <a href="#changelrn" data-toggle="modal" class="btn btn-default">Update LRN</a>
						  <a href="#runningfor" data-toggle="modal" class="btn btn-info">Running for</a>
						 
						  </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="changelrn" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 class="modal-title"><center>LEARNER'S INFORMATION</center></h3>
		
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
			<label>OLD LEARNER REFRENCE NUMBER</label>
			<input type="text" value="<?php echo $_GET['l'];?>" class="form-control" disabled>
			<label>ENTER NEW LEARNER REFRENCE NUMBER</label>
			<input type="text" name="newlrn" class="form-control" autofocus><hr/>
		
			
		
	    </div>
		 <div class="modal-footer">
			<input type="submit" name="updatelrn" value="Update" class="btn btn-primary" >
			<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
			</div>
		</form>
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign-->


<!-- Modal for Re-assign-->
<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="changesection" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        
          <h3 class="modal-title"><center>UPDATE LEARNER SECTION</center></h3>
		
        </div>
		<form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
							if ($_SESSION['Sem']=="First Semester")
								{
									
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."'ORDER BY tbl_student.Lname Asc");
												
								}
										
							elseif ($_SESSION['Sem']=="Second Semester")
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");
										
								}	
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");	
					}
					
					$data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					if ($data['Picture']=="")
					{
					echo '<img src="../../pcdmis/logo/user.png" width="150" height="160" align="right">';	
					}else{
					echo '<img src="../../online-class/requirements/'.$data['Picture'].'" width="150" height="160" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
						{
							echo  '<p>Grade & Section: '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}else{
							echo  '<p>Grade & Section: Grade '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}
					echo  '<p>New assignment: 
								<select name="newsection" class="form-control" required>
									<option value="">--select--</option>';
								$mynewsec=mysqli_query($con,"SELECT * FROM tbl_section  WHERE tbl_section.Grade = '".$_GET['Code']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."'AND tbl_section.School_Year='".$_SESSION['year']."'");	
								while($rowsec=mysqli_fetch_array($mynewsec))
								{
									if ($rowsec['Grade']=='Nursery' || $rowsec['Grade']=='Kinder 1' || $rowsec['Grade']=='Kinder 2')
									{
									echo '<option value="'.$rowsec['SecCode'].'">'.$rowsec['Grade'].'-'.$rowsec['SecDesc'].'</option>';
									}else{
										echo '<option value="'.$rowsec['SecCode'].'">Grade '.$rowsec['Grade'].'-'.$rowsec['SecDesc'].'</option>';
									}
								}
								echo '</select></p>
								
								';
		?>
	    </div>
		 <div class="modal-footer">
		<input type="submit" name="change_section" value="SUBMIT" class="btn btn-primary">
		<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
	    </div>
		</form>
	</div>
</div>
 </div></div>
			  


<!-- Modal for Re-assign-->
<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="runningfor" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 class="modal-title"><center>SET LEARNER'S AS ASPIRANT CANDIDATE</center></h3>
		
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
			<?php
			if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
							if ($_SESSION['Sem']=="First Semester")
								{
									
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."'ORDER BY tbl_student.Lname Asc");
												
								}
										
							elseif ($_SESSION['Sem']=="Second Semester")
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");
										
								}	
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_learners.lrn ='".$_SESSION['lrn']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_student.Lname Asc");	
					}
					
					$data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					if ($data['Picture']=="")
					{
					echo '<img src="../../pcdmis/logo/user.png" width="150" height="160" align="right">';	
					}else{
					echo '<img src="../../online-class/requirements/'.$data['Picture'].'" width="150" height="160" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
						{
							echo  '<p>Grade & Section: '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}else{
							echo  '<p>Grade & Section: Grade '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}
					echo  '
					<label>RUNNING FOR: </label>
					<select name="candidate" class="form-control" required>
					  <option value="">--Select Position--</option>';
					  $myposition=mysqli_query($con,"SELECT * FROM tbl_ssg_position ORDER BY PosNo Asc");
					  while($rowpos=mysqli_fetch_array($myposition))
					  {
						echo '<option value="'.$rowpos['Positioninfo'].'">'.$rowpos['Positioninfo'].'</option>';
					    
					  }
					  
					  echo '</select>	
					  <label>PARTY LIST: </label>
					  <input type="text" name="party" class="form-control" required>
					  ';
				
					?>
		
	    </div>
		 <div class="modal-footer">
			<input type="submit" name="running" value="SET AS CANDIDATE" class="btn btn-primary" >
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</form>
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign-->


<!-- Modal for Re-assign-->
<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="resetaccount" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 class="modal-title"><center>UPDATE LEARNER'S ACCOUNT</center></h3>
		
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
			<?php
			if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
							if ($_SESSION['Sem']=="First Semester")
								{
									
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."'ORDER BY tbl_student.Lname Asc");
												
								}
										
							elseif ($_SESSION['Sem']=="Second Semester")
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");
										
								}	
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_learners.lrn ='".$_SESSION['lrn']."' AND tbl_learners.SchoolID='".$_SESSION['school_id']."' ORDER BY tbl_student.Lname Asc");	
					}
					
					$data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					if ($data['Picture']=="")
					{
					echo '<img src="../../pcdmis/logo/user.png" width="150" height="160" align="right">';	
					}else{
					echo '<img src="../../online-class/requirements/'.$data['Picture'].'" width="150" height="160" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
						{
							echo  '<p>Grade & Section: '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}else{
							echo  '<p>Grade & Section: Grade '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}
					echo  '
					<label>New Password: </label>
					<input type="password" name="newpass" class="form-control">
					
					';
				
					?>
		
	    </div>
		 <div class="modal-footer">
			<input type="submit" name="changepass" value="Update" class="btn btn-primary" >
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</form>
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign-->


           
<!-- Modal for Re-assign-->
<div class="panel-body">
                            
           <!-- Modal -->
      <div class="modal fade" id="tagforexam" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
    
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 class="modal-title"><center>SET LEARNER'S AS EXAMINEE</center></h3>
		
        </div>
		<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
		if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
							if ($_SESSION['Sem']=="First Semester")
								{
									
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."'ORDER BY tbl_student.Lname Asc");
												
								}
										
							elseif ($_SESSION['Sem']=="Second Semester")
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['school_id']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");
										
								}	
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['lrn']."' AND tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['lrn']."' ORDER BY tbl_student.Lname Asc");	
					}
					
					$data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					if ($data['Picture']=="")
					{
					echo '<img src="../../pcdmis/logo/user.png" width="150" height="160" align="right">';	
					}else{
					echo '<img src="../../online-class/requirements/'.$data['Picture'].'" width="150" height="160" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
						if ($data['Grade']=='Nursery' || $data['Grade']=='Kinder 1' || $data['Grade']=='Kinder 2')
						{
							echo  '<p>Grade & Section: '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}else{
							echo  '<p>Grade & Section: Grade '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}
					
					echo '
					       			
						 <label>Type of Examination:</label>
					      <select name="type_of_exam" class="form-control" required onchange="view_record(this.value)">
									<option value="">--select--</option>';
									$exam=mysqli_query($con,"SELECT * FROM tbl_assessment_type_of_exam WHERE Examination_status='Open'");
									while($rowexam=mysqli_fetch_array($exam))
									{
									echo '<option value="'.$rowexam['ExamCode'].'">'.$rowexam['Exam_Name'].'</option>';
									}
																	
									echo '</select>	
								';
				
					?>
			
			
		
	    </div>
		 <div class="modal-footer">
				<div id="learnerstatus"></div>
			
		
 
 </div>
		</form>
		      </div>
		      </div>
			  </div></div>
			  
<!-- Ending Modal for re-assign-->




 <div class="panel-body">
   <div class="modal fade" id="studyload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   
      <div class="modal-dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LIST OF SUBJECTS</center></h3>
		
        </div>
        <div class="modal-body" style="overflow-x:auto;">
		<form  action="" Method="POST" enctype="multipart/form-data">
				<table width="100%" class="table table-striped table-bordered table-hover" >
                           <thead>
								<tr>
									
									<th rowspan="2">Subject Description</th>
									<th colspan="3">Schedule</th>
									<th rowspan="2">Teacher</th>
									<th rowspan="2"></th>
									
								</tr>
									<th>Time</th>
									<th>Day</th>
									<th>Room</th>
								<tr>
									
								</tr>
							</thead>
							
                                <tbody>
								
								
								<?php
								$no=0;
								if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
								{
								$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_senior_sub_strand ON class_program.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['school_id']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."'");
								}elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10)
								{
								$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_jhs_subject ON class_program.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['school_id']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."'");
								}elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
									$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_element_subject ON class_program.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['school_id']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."'");
								}
								while($subrow=mysqli_fetch_array($subsched))
								{
									$no++;
								echo '<tr>
										
										<td>'.$subrow['LearningAreas'].'</td>
										<td>'.$subrow['SecTime'].'</td>
										<td>'.$subrow['SecDay'].'</td>
										<td>'.$subrow['SecDesc'].'</td>
										<td>'.$subrow['Emp_LName'].','.$subrow['Emp_FName'].'</td>
										<td><input type="checkbox" name="sub'.$no.'" value="'.$subrow['SubNo'].'"></td>
									</tr>';
								}
								?>
								
								
                                </tbody>
								</table>
			<input type="submit" name="save" value="SUBMIT" class="btn btn-success" style="float:right;"><br/><br/>
		
		 </div></form>
	</div>
</div>
 </div></div>
			  
<!-- Ending Modal for re-assign-->


 <script>
 function view_record(str) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("learnerstatus").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","tag.php?id="+str,false);
  xmlhttp.send();
}
 </script>