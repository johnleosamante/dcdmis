  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LEARNER'S INFORMATION</center></h3>
		
        </div>
        <div class="modal-body">
		
		<?php
		session_start();
include("../vendor/jquery/function.php");
					$_SESSION['lrn']=$_GET['id'];
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_registration INNER JOIN tbl_student ON tbl_registration.lrn =tbl_student.lrn WHERE tbl_registration.SchoolID='".$_SESSION['school_id']."' AND tbl_registration.lrn ='".$_GET['id']."' ORDER BY tbl_student.Lname Asc")or die ("Retirees Information error");
					 $data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					echo '<img src="'.$data['Picture'].'" width="150" height="160" align="right">';
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
					echo  '<p>Grade Level: '.$data['Grade'].'</p>';
					echo  '<p>Date Registered: '.$data['Date_enrolled'].'</p><hr/>';
					echo '<form action="" method="POST">
						<label>Assign Section</label><br/>';
					echo '<label><select name="section" class="form-control">
								<option value="">--Select--</option>';
								$mysection=mysqli_query($con,"SELECT * FROM tbl_section WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year='".date("Y")."' AND tbl_section.Grade='".$data['Grade']."' ORDER BY tbl_section.SecCode Asc");
								while($myrow=mysqli_fetch_array($mysection))
								{
									echo '<option value="'.$myrow['SecCode'].'">'.$myrow['SecDesc'].'</option>';
								}
						echo '</select>
						 </label>
						 <input type="submit" name="assign" value="SET SECTION" class="btn btn-primary" style="float:right;">
						 </form>';
				
					?>
					
		</div>
		<!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->
		