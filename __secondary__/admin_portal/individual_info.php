<?php
//Add Subject 
                    $_SESSION['lrn']=$_GET['id'];
					$_SESSION['Grade']=$_GET['Code'];
					if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
							{
								$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND tbl_shs_tor.SecCode='".$_SESSION['SecCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
							}
							elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
							}
							elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
							}
							
							if (mysqli_num_rows($mysubject)==0)
						{
								if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
										{
										$no=0;
										$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_senior_sub_strand ON class_program.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND tbl_section.Grade='".$_SESSION['Grade']."'");
										while ($subrow=mysqli_fetch_array($subsched))
										{
											mysqli_query($con,"INSERT INTO tbl_shs_tor VALUES(NULL,'".$_SESSION['Grade']."','".$subrow['SubNo']."','0','0','".$_SESSION['Sem']."','".$_SESSION['year']."','".$_SESSION['lrn']."','".$_SESSION['SecCode']."')");	
											
										}
										}
										
										
										elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
										$no=0;
										$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_jhs_subject ON class_program.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND tbl_section.Grade='".$_SESSION['Grade']."'");
										while ($subrow=mysqli_fetch_array($subsched))
										{
											
											mysqli_query($con,"INSERT INTO junior_tor VALUES(NULL,'".$_SESSION['Grade']."','".$subrow['SubNo']."','0','0','0','0','".$_SESSION['year']."','".$_SESSION['lrn']."','".$_SESSION['SecCode']."')");	
											
										}
										}
										
										
										elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
											$no=0;
											$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_element_subject ON class_program.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND tbl_section.Grade='".$_SESSION['Grade']."' ");
										while ($subrow=mysqli_fetch_array($subsched))
										{
											
											mysqli_query($con,"INSERT INTO junior_tor VALUES(NULL,'".$_SESSION['Grade']."','".$subrow['SubNo']."','0','0','0','0','".$_SESSION['year']."','".$_SESSION['lrn']."','".$_SESSION['SecCode']."')");	
											
										}
									}
									
						}
							
						//End add subject
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
					<a href="#studyload" style="float:right;" class="btn btn-primary" data-toggle="modal">Add subject</a>
					
					<?php
					
					
					echo '
					<h3>Learners Information</h3>';
					
					
					$str=sha1("Pagadian City Division Data Management Information System");
					if (isset($_POST['submit']))
					{
						if ($_SESSION['Grade']=='11' ||$_SESSION['Grade']=='12')
					{
						if ($_SESSION['Sem']=='First Semester')
						{
						mysqli_query($con,"UPDATE first_semester SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");	
						}elseif ($_SESSION['Sem']=='Second Semester')
						{
						mysqli_query($con,"UPDATE second_semester SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");	
							
						}
					}else{
						mysqli_query($con,"UPDATE tbl_learners SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND School_Year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."' LIMIT 1");	
						
					}
					mysqli_query($con,"UPDATE tbl_student SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
					mysqli_query($con,"UPDATE tbl_registration SET lrn='".$_POST['newlrn']."' WHERE lrn='".$_SESSION['lrn']."' AND school_year='".$_SESSION['year']."' AND SchoolID='".$_SESSION['SchoolID']."'LIMIT 1");
						if(mysqli_affected_rows($con)==1)
						{
						$Err="Learner reference number is Successfully Updated!";	
                      echo '<div class="panel-heading">
							<script type="text/javascript">
								$(document).ready(function(){						
								$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
								
								});</script>
								';	
						echo '<div class="alert alert-success">'.$Err.'<script>{window.location.href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&v='.urlencode(base64_encode("dashboard")).'";}</script></div>
							 
                        </div>';
						
						}
					}elseif(isset($_POST['save']))
					{
						
						
						if ($_SESSION['Grade']==11 || $_SESSION['Grade']==12)
						{
							$no=0;
							$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_senior_sub_strand ON class_program.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."'");
								while ($subrow=mysqli_fetch_array($subsched))
								{
									$no++;
									if (isset($_POST['sub'.$no]))
									{
									mysqli_query($con,"INSERT INTO tbl_shs_tor VALUES(NULL,'".$_SESSION['Grade']."','".$_POST['sub'.$no]."','0','0','".$_SESSION['Sem']."','".$_SESSION['year']."','".$_SESSION['lrn']."','".$_SESSION['SecCode']."')");	
									}
								}
						}elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
							$no=0;
							$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_jhs_subject ON class_program.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' ");
								while ($subrow=mysqli_fetch_array($subsched))
								{
									$no++;
									if (isset($_POST['sub'.$no]))
									{
									mysqli_query($con,"INSERT INTO junior_tor VALUES(NULL,'".$_SESSION['Grade']."','".$_POST['sub'.$no]."','0','0','0','0','".$_SESSION['year']."','".$_SESSION['lrn']."','".$_SESSION['SecCode']."')");	
									}
								}
						}elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
							$no=0;
							$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_element_subject ON class_program.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' ");
								while ($subrow=mysqli_fetch_array($subsched))
								{
									$no++;
									if (isset($_POST['sub'.$no]))
									{
									mysqli_query($con,"INSERT INTO junior_tor VALUES(NULL,'".$_SESSION['Grade']."','".$_POST['sub'.$no]."','0','0','0','0','".$_SESSION['year']."','".$_SESSION['lrn']."','".$_SESSION['SecCode']."')");	
									}
								}
						}
						if(mysqli_affected_rows($con)==1)
						{
						$Err="Subject load is Successfully Added!";	
                      echo '<div class="panel-heading">
							<script type="text/javascript">
								$(document).ready(function(){						
								$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
								
								});</script>
								';	
						echo '<div class="alert alert-success">'.$Err.'</div>
							 
                        </div>';
						//$_SESSION['lrn']='';
					}
					}
					?>
					</div>
					<!-- /.panel-heading -->
                        <div class="panel-body">
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
					
					echo '<b>';
					if ($data['Picture']==NULL)
					{
					echo '<img src="../../online-class/logo/user.png" width="250" height="260" align="right" style="border-radius:50%;">';
						
					}else{
					echo '<img src="../../online-class/'.$data['Picture'].'" width="250" height="260" align="right" style="border-radius:50%;">';
					}
					echo '<p>LRN: '.$data['lrn'].'&nbsp;<a href="#changelrn" data-toggle="modal" >Edit</a></p>';
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
					$advice=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID =tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['SecCode']."' AND tbl_section.SchoolID='".$_SESSION['SchoolID']."'");	
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
									<th rowspan="2">Subject Description</th>
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
								$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND tbl_shs_tor.SecCode='".$_SESSION['SecCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
							}
							elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
							}
							elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade']."' AND class_program.Grade='".$_SESSION['Grade']."' GROUP BY class_program.SubNo");
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
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LEARNER'S INFORMATION</center></h3>
		
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
			<label>OLD LEARNER REFRENCE NUMBER</label>
			<input type="text" value="<?php echo $_GET['id'];?>" class="form-control" disabled>
			<label>ENTER NEW LEARNER REFRENCE NUMBER</label>
			<input type="text" name="newlrn" class="form-control" autofocus><hr/>
			<input type="submit" name="submit" value="Update" class="btn btn-primary" >
			
		</form>
	    </div>
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
								$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_senior_sub_strand ON class_program.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."'");
								}elseif ($_SESSION['Grade']>=7 AND $_SESSION['Grade']<=10)
								{
								$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_jhs_subject ON class_program.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."'");
								}elseif ($_SESSION['Grade']>=1 AND $_SESSION['Grade']<=6){
									$subsched=mysqli_query($con,"SELECT * FROM class_program INNER JOIN tbl_element_subject ON class_program.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON class_program.SecCode =tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID=tbl_employee.Emp_ID WHERE class_program.SchoolID='".$_SESSION['SchoolID']."' AND class_program.SecCode='".$_SESSION['SecCode']."' AND class_program.SchoolYear='".$_SESSION['year']."'");
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
			  
<!-- Ending Modal for re-assign->
