<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");

?>
  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LEARNER'S INFORMATION</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		foreach ($_GET as $key => $data)
			{
			$lrn=$_GET[$key]=base64_decode(urldecode($data));
				
			}
			        $_SESSION['Grade']=$_GET['Grade'];
					$_SESSION['lrn']=$lrn;
					if ($_SESSION['Grade']==11 ||   $_SESSION['Grade']==12)
					{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn =tbl_student.lrn WHERE tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.lrn ='".$lrn."' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.Grade='".$_GET['Grade']."' AND tbl_registration.SemCode='".$_SESSION['Sem']."' ORDER BY tbl_student.Lname Asc");
						
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn =tbl_student.lrn WHERE tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.lrn ='".$lrn."' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.Grade='".$_GET['Grade']."' ORDER BY tbl_student.Lname Asc");
					}
					$data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					if ($data['Picture']==NULL)
					{
					echo '<img src="/../online-class/logo/user.png" width="240" height="250" align="right">';	
					}else{
					echo '<img src="/../online-class/'.$data['Picture'].'" width="240" height="250" align="right">';
					}
					if ($_SESSION['Grade']==11 ||   $_SESSION['Grade']==12)
					{
						if ($_SESSION['Sem']=='First Semester')
						{
						 $mysec=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_section ON first_semester.SecCode=tbl_section.SecCode WHERE first_semester.lrn='".$_SESSION['lrn']."' LIMIT 1");			
						}elseif ($_SESSION['Sem']=='Second Semester')
						{
						  $mysec=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_section ON second_semester.SecCode=tbl_section.SecCode WHERE second_semester.lrn='".$_SESSION['lrn']."' LIMIT 1");			
						}
					}else{
						$mysec=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_section ON tbl_learners.SecCode=tbl_section.SecCode WHERE tbl_learners.lrn='".$_SESSION['lrn']."' LIMIT 1");			
					}
					$newsection=mysqli_fetch_assoc($mysec);
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Average Grade.: '.$data['LGWA'].' %</p>';
					echo  '<p>Grade Level: '.$data['Grade'].'</p>';
					echo  '<p>Section Assign: '.$newsection['SecDesc'].'</p>
					 
					<hr/>';
					echo '<form action="" method="POST" enctype="multipart/form-data">
						<input type="submit" name="updatesection" value="SET SECTION" class="btn btn-primary" style="float:right;">
						<label style="width:40%;">Assign Section</label><br/>';
					echo '<label style="width:40%;"><select name="section" class="form-control" required>
								<option value="">--Select--</option>';
								
								$mysection=mysqli_query($con,"SELECT * FROM tbl_section WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_section.Grade='".$_GET['Grade']."' ORDER BY tbl_section.SecCode Asc");
								while($myrow=mysqli_fetch_array($mysection))
								{
									echo '<option value="'.$myrow['SecCode'].'">'.$myrow['SecDesc'].'</option>';
								}
						echo '</select>
						 </label><br/>';
						if ($_GET['Grade']=='11' || $_GET['Grade']=='12')
						{
					echo '<label style="width:40%;">Track / Strand</label><br/>';
					echo '<label style="width:40%;"><select name="track" class="form-control">
								';
						$myTrack=mysqli_query($con,"SELECT * FROM tbl_qualification_by_school INNER JOIN tbl_qualification ON tbl_qualification_by_school.QualCode = tbl_qualification.SpCode WHERE tbl_qualification.Grade='".$_GET['Grade']."' AND tbl_qualification_by_school.SchoolID ='".$_SESSION['school_id']."' AND tbl_qualification_by_school.QualSem ='".$_SESSION['Sem']."'ORDER BY tbl_qualification.Description Asc");
							while($myrowtrack=mysqli_fetch_array($myTrack))
								{
									echo '<option value="'.$myrowtrack['SpCode'].'">'.$myrowtrack['Description'].'</option>';
								}
						echo '</select>
						 </label>';
						}							
					echo '
						 </form>';
				
					?>
					
		</div>
		