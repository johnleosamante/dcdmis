 
 
 <script>
 function showGrade(str) {
 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("view_data").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","require/device_used.php?id="+str,true);
  xmlhttp.send();
}
 </script>
 
 <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>LEARNER'S INFORMATION</center></h3>
		
        </div>
        <div class="modal-body">
		<?php
		session_start();
	include("../../pcdmis/vendor/jquery/function.php");
	foreach ($_GET as $key => $data)
		{
		$code=$_GET[$key]=base64_decode(urldecode($data));	
		}

					$_SESSION['Grade']=$code;
					$_SESSION['LRN']=$_GET['id'];
					if ($_SESSION['Grade']=='11' || $_SESSION['Grade']=='12')
					{
							if ($_SESSION['Sem']=="First Semester")
								{
									
									$myinfo=mysqli_query($con,"SELECT * FROM first_semester INNER JOIN tbl_student ON first_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON first_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND first_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND first_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['LRN']."'ORDER BY tbl_student.Lname Asc");
												
								}
										
							elseif ($_SESSION['Sem']=="Second Semester")
								{
									$myinfo=mysqli_query($con,"SELECT * FROM second_semester INNER JOIN tbl_student ON second_semester.lrn =tbl_student.lrn INNER JOIN tbl_section ON second_semester.SecCode =tbl_section.SecCode WHERE tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND second_semester.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND second_semester.SchoolID='".$_SESSION['SchoolID']."' AND tbl_student.lrn ='".$_SESSION['LRN']."' ORDER BY tbl_student.Lname Asc");
										
								}	
					}else{
					$myinfo=mysqli_query($con,"SELECT * FROM tbl_learners INNER JOIN tbl_student ON tbl_learners.lrn =tbl_student.lrn INNER JOIN tbl_section ON tbl_learners.SecCode =tbl_section.SecCode  WHERE tbl_learners.lrn = '".$_SESSION['LRN']."' AND tbl_section.SchoolID='".$_SESSION['SchoolID']."' AND tbl_learners.School_Year ='".$_SESSION['year']."' AND tbl_section.School_Year='".$_SESSION['year']."' AND tbl_student.lrn ='".$_SESSION['LRN']."' ORDER BY tbl_student.Lname Asc");	
					}
					
					$data=mysqli_fetch_assoc($myinfo);
					
					echo '<b>';
					if ($data['Picture']=="")
					{
					echo '<img src="../../online-class/logo/user.png" width="150" height="160" align="right">';	
					}else{
					echo '<img src="../../online-class/'.$data['Picture'].'" width="150" height="160" align="right">';
					}
					echo '<p>LRN: '.$data['lrn'].'</p>';
					echo '<p>Learner Name: '.$data['Lname'].', '.$data['FName'].' '.$data['MName'].'</p>';
					echo '<p>Gender: '.$data['Gender'].'</p>';
					echo '<p>Home Address: '.$data['Home_Address'].'</p>';
					echo  '<p>Birthdate: '.$data['Birthdate'].'</p>';
					echo  '<p>Contact No.: '.$data['ContactNo'].'</p>';
						if ($data['Grade']=='Kinder')
						{
							echo  '<p>Grade & Section: '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}else{
							echo  '<p>Grade & Section: Grade '.$data['Grade'].' - '.$data['SecDesc'].'</p>';
						}
					$mymodality	=mysqli_query($con,"SELECT * FROM tbl_learning_modality WHERE LRN='".$_SESSION['LRN']."' AND School_Year='".$_SESSION['year']."' LIMIT 1");
					if (mysqli_num_rows($mymodality)==0)
					{
					echo  '<form action="" method="POST" enctype="multipart/form-data">
					  <label>Type of Learning Modality:</label>
					<select name="type_of_modality" class="form-control" onchange="showGrade(this.value)" required>
						<option value="">--Select--</option>
						<option value="Online">Online / Digital Module</option>
						<option value="Printed">Printed Module</option>
						
					</select>
					
					<div id="view_data"></div>
					
					
					<hr/>
					
					<input type="submit" name="modality" value="SAVE" class="btn btn-primary"></form>';
					}else{
						echo '<hr/><h4>Learning Modality is already set!!</h4>';
					}
					?>
		</div>