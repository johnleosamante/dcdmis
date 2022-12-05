<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");

?>
  <div class="modal-header">
          
          <h3 class="modal-title"><center>LEARNER'S INFORMATION</center></h3>
		
        </div>
		<form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<?php
		foreach ($_GET as $key => $data)
			{
			$lrn=$_GET[$key]=base64_decode(urldecode($data));
				
			}
					
					$_SESSION['Grade']=$_GET['Grade'];
					$_SESSION['lrn']=$lrn;
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn =tbl_student.lrn WHERE tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.lrn ='".$lrn."' AND tbl_registration.school_year ='".$_SESSION['year']."' AND tbl_registration.Grade='".$_GET['Grade']."' ORDER BY tbl_student.Lname Asc LIMIT 1");
					$data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					if ($data['Picture']==NULL)
					{
					echo '<img src="../../pcdmis/logo/user.png" width="240" height="250" align="right">';	
					}else{
					echo '<img src="../../online-class/'.$data['Picture'].'" width="240" height="250" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Average Grade.: '.$data['LGWA'].' %</p>';
					echo  '<p>Grade Level: '.$data['Grade'].'</p>';
					echo  '<p>Date Registered: '.$data['Date_enrolled'].'</p>
					       <label style="width:40%;">Assign Section</label><br/>
				        <label style="width:40%;"><select name="section" class="form-control" required>
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
					echo '</div>';
					
				
					?>
					 <div class="modal-footer">
					 <?php
					
					 ?>
					   <input type="submit" name="assign" value="SET SECTION" class="btn btn-primary">
						<button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
					</div>
		 </form>