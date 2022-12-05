<?php
    $_SESSION['lrn']=$_GET['lrn'];
         
		 if (isset($_POST['changelrn']))
		 {
			 mysqli_query($con,"UPDATE tbl_student SET lrn = WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
			if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
			{
				if ($_SESSION['Sem']=='First Semester')
				{
				 mysqli_query($con,"UPDATE first_semester SET lrn = WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");	
				}elseif ($_SESSION['Sem']=='Second Semester')
				{
					 mysqli_query($con,"UPDATE second_semester SET lrn = WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
				}
				mysqli_query($con,"UPDATE tbl_shs_tor SET lrn = WHERE lrn='".$_SESSION['lrn']."'");
			}else{
			  
			  mysqli_query($con,"UPDATE tbl_learners SET lrn = WHERE lrn='".$_SESSION['lrn']."' LIMIT 1");
			  mysqli_query($con,"UPDATE junior_tor SET lrn = WHERE lrn='".$_SESSION['lrn']."'");
			} 
			 if (mysqli_affected_rows($con)==1)
			 {
				 $Err = "Learner Reference Number Successfully updated";
						echo '<script type="text/javascript">
							$(document).ready(function(){						
							$( "div.alert" ).fadeIn( 300 ).delay( 3000 ).fadeOut( 400 );
										
								});</script>
								';	
						echo '<div class="alert alert-success">'.$Err.'</div>';
			 }
		 }
							
	//End add subject
?>
	 
	<?php
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
			<div class="col-lg-12">
			 <div class="panel panel-default">
				<div class="panel-heading">
				<?php
				echo '<a href="" class="btn btn-primary">Print Studyload</a>
				<a href="./?'.$str.'7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&lrn='.urlencode(base64_encode($_SESSION['lrn'])).'&v='.urlencode(base64_encode("profile")).'" class="btn btn-secondary" style="float:right;">Back</a>';
				?>
				</div>
				 <div class="panel-body">
			<?php
			  if ($data['Picture']==NULL)
					{
					echo '<img src="../../pcdmis/logo/user.png" width="100" height="100" align="right" style="border-radius:50%;">';
						
					}else{
					echo '<img src="../'.$data['Picture'].'" width="100" height="100" align="right" style="border-radius:50%;">';
					}
					//Adviser
				$myadviser=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID WHERE tbl_section.SecCode='".$_SESSION['CurrentCode']."' LIMIT 1");	
				$rowadvic=mysqli_fetch_assoc($myadviser);
				$Middle=mb_strimwidth($rowadvic['Emp_MName'],0,1);
			?>
                <ul class="list-unstyled" style="text-transform:uppercase;">
							<li>
								<label style="width:150px;">LRN: </label><label> <?php echo $_SESSION['lrn'];?> <a href="#editlrn" data-toggle="modal">Edit</a></label>
							</li>
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
				
				
				<h4>Subject Load</h4>
							
					<table class="table table-striped table-bordered table-hover">
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
							<tbody>
							<?php
							
							if ($_SESSION['Grade_Level']==11 || $_SESSION['Grade_Level']==12)
							{
								$mysubject=mysqli_query($con,"SELECT * FROM tbl_shs_tor INNER JOIN tbl_senior_sub_strand ON tbl_shs_tor.SubNo = tbl_senior_sub_strand.StrandsubCode INNER JOIN class_program on tbl_shs_tor.SubNo = class_program.SubNo INNER JOIN tbl_section ON tbl_shs_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE tbl_shs_tor.lrn='".$_SESSION['lrn']."' AND tbl_shs_tor.SemCode='".$_SESSION['Sem']."' AND tbl_shs_tor.SYCode='".$_SESSION['year']."' AND class_program.Semester='".$_SESSION['Sem']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND tbl_shs_tor.SecCode='".$_SESSION['CurrentCode']."' AND tbl_shs_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							elseif ($_SESSION['Grade_Level']>=7 AND $_SESSION['Grade_Level']<=10){
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_jhs_subject ON junior_tor.SubNo = tbl_jhs_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
							}
							else{
								$mysubject=mysqli_query($con,"SELECT * FROM junior_tor INNER JOIN class_program on junior_tor.SubNo = class_program.SubNo INNER JOIN tbl_element_subject ON junior_tor.SubNo = tbl_element_subject.SubNo INNER JOIN tbl_section ON junior_tor.SecCode = tbl_section.SecCode INNER JOIN tbl_employee ON class_program.Emp_ID =tbl_employee.Emp_ID WHERE junior_tor.lrn='".$_SESSION['lrn']."'  AND junior_tor.SYCode='".$_SESSION['year']."'  AND junior_tor.SecCode='".$_SESSION['CurrentCode']."' AND class_program.SchoolYear='".$_SESSION['year']."' AND class_program.SchoolID='".$_SESSION['SchoolID']."' AND junior_tor.GradeNo='".$_SESSION['Grade_Level']."' AND class_program.Grade='".$_SESSION['Grade_Level']."' AND class_program.SecCode='".$_SESSION['CurrentCode']."' GROUP BY class_program.SubNo ORDER BY LearningAreas Asc");
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
						?>
						</tbody>
						</table>
						
						
						
								
   <!-- Modal for Re-assign-->
<div class="panel-body">
                            
                 <!-- Modal -->
	 <div class="modal fade" id="editlrn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Update Learner Reference Number</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="" Method="POST" enctype="multipart/form-data">
		<label>Old Lerner Reference Number</label>
		<input type="text" class="form-control" value="<?php echo $_SESSION['lrn']; ?>" disabled>
		<label>New Lerner Reference Number</label>
		<input type="text" name="newLRN" class="form-control"><hr/>
		<input type="submit" name="changelrn" value="CHANGE" class="btn btn-primary">
		</form>
		</div>
		

	</div></div>
</div>
  </div>
 
				