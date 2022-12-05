<?php
session_start();
include_once("../../pcdmis/vendor/jquery/function.php");
?>

<div class="modal-header">

<h4 class="modal-title" id="myModalLabel">Update report</h4>
</div>
	<form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		<?php
            date_default_timezone_set("Asia/Manila");
			$_SESSION['SubNo']=$_GET['id'];
					  if ($_GET['Category']=='Elementary')
							{
							$mysubject=mysqli_query($con,"SELECT * FROM tbl_elementary_subject WHERE SchoolID ='".$_SESSION['school_id']."' AND SubNo ='".$_GET['id']."' ORDER BY GradeLevel Asc");
							$rowdata=mysqli_fetch_assoc($mysubject);	
							echo  '<div class="col-lg-6">
                           <label>Date submitted:</label>
	                        <input type="date" class="form-control" value="'.date('Y-m-d').'" disabled>
                             <label>Current Week #:</label>					       
                            <input type="text" value="'.$rowdata['WeekNo'].'" class="form-control" disabled>
                              </div>
							 <div class="col-lg-6">
							 <label>Grade Level :</label>					       
                            <select  name="GLevel" class="form-control" required>';
							if ($rowdata['GradeLevel']=='Kinder')
							{
							echo '<option value="'.$rowdata['GradeLevel'].'">'.$rowdata['GradeLevel'].'</option>';
								
							}else{
							echo '<option value="'.$rowdata['GradeLevel'].'">Grade '.$rowdata['GradeLevel'].'</option>';
							}
													
							echo '</select>
							<label># of Learners:</label>					       
                            <input type="number" name="No_of_learner" value="'.$rowdata['No_of_learner'].'" class="form-control" placeholder="# of Learners" required>
                           <br/>  </div>
							<input type="text" value="Number of Printed Modules Distributed" class="form-control" style="text-align:center;"disabled>
							 <div class="col-lg-6">
							<label>English:</label>					       
                            <input type="number" name="English" value="'.$rowdata['English'].'" class="form-control"  required>
                            <label>Science:</label>					       
                            <input type="number" name="Science" value="'.$rowdata['Science'].'" class="form-control"  required>
                            <label>Math:</label>					       
                            <input type="number" name="Math" value="'.$rowdata['Math'].'" class="form-control"  required>
                            <label>Filipino:</label>					       
                            <input type="number" name="Filipino" value="'.$rowdata['Filipino'].'" class="form-control"  required>
                            <label>Aral. Pan.:</label>					       
                            <input type="number" name="AralPan" value="'.$rowdata['AralPan'].'" class="form-control"  required>
                            
							</div>
							 <div class="col-lg-6">
							 <label>E.S.P:</label>					       
                            <input type="number" name="ESP" value="'.$rowdata['ESP'].'" class="form-control"  required>
							<label>T.L.E/E.P.P:</label>					       
                            <input type="number" name="TLE" value="'.$rowdata['TLE'].'" class="form-control"  required>
                            <label>MAPEH:</label>					       
                            <input type="number" name="MAPEH" value="'.$rowdata['MAPEH'].'" class="form-control"  required>
							<label>MOTHER TONGUE:</label>					       
                            <input type="number" name="Mother_Tongue" value="'.$rowdata['Mother_tongue'].'" class="form-control"  required>
							<label>RO Thematic:</label>					       
                            <input type="number" name="ROThematic" value="'.$rowdata['RO_Thematic'].'" class="form-control"  required>
							<label>Project RUSH:</label>					       
                            <input type="number" name="ProjRush" value="'.$rowdata['Project_Rush'].'" class="form-control"  required>
							
							</div>';
								
							}elseif ($_GET['Category']=='Secondary')
							{
							$mysubject=mysqli_query($con,"SELECT * FROM tbl_secondary_subject WHERE SchoolID ='".$_SESSION['school_id']."' AND SubNo ='".$_GET['id']."' ORDER BY GradeLevel Asc");
							$rowdata=mysqli_fetch_assoc($mysubject);								
					  echo  '<div class="col-lg-6">
                           <label>Date submitted:</label>
	                        <input type="date" class="form-control" value="'.date('Y-m-d').'" disabled>
                            <input type="hidden" name="datesub"  class="form-control" value="'.date('Y-m-d').'" required>
                            <label>Current Week #:</label>					       
                            <input type="text"  name="No_of_week" value="'.$rowdata['WeekNo'].'" class="form-control" disabled>
                            </div>
							 <div class="col-lg-6">
							  <label>Grade Level :</label>					       
                            <select  name="GLevel" class="form-control" required>
							<option value="'.$rowdata['GradeLevel'].'">Grade '.$rowdata['GradeLevel'].'</option>
							<option value="7">Grade 7</option>
							<option value="8">Grade 8</option>
							<option value="9">Grade 9</option>
							<option value="10">Grade 10</option>
							
							</select>
							<label># of Learners:</label>					       
                            <input type="number" name="No_of_learner" class="form-control" value="'.$rowdata['No_of_learner'].'" required>
                           <br/>  </div>
							<input type="text" value="Number of Printed Modules Distributed" class="form-control" style="text-align:center;"disabled>
							 <div class="col-lg-6">
							<label>English:</label>					       
                            <input type="number" name="English" value="'.$rowdata['English'].'" class="form-control"  required>
                            <label>Science:</label>					       
                            <input type="number" name="Science" value="'.$rowdata['Science'].'" class="form-control"  required>
                            <label>Math:</label>					       
                            <input type="number" name="Math" value="'.$rowdata['Math'].'" class="form-control"  required>
                            <label>Filipino:</label>					       
                            <input type="number" name="Filipino" value="'.$rowdata['Filipino'].'" class="form-control"  required>
                            <label>Aral. Pan.:</label>					       
                            <input type="number" name="AralPan" value="'.$rowdata['AralPan'].'" class="form-control"  required>
                            <label>E.S.P:</label>					       
                            <input type="number" name="ESP" value="'.$rowdata['ESP'].'" class="form-control"  required>
							</div>
							 <div class="col-lg-6">
							<label>T.L.E:</label>					       
                            <input type="number" name="TLE" value="'.$rowdata['TLE'].'" class="form-control"  required>
                            <label>Music:</label>					       
                            <input type="number" name="Music" value="'.$rowdata['Music'].'" class="form-control"  required>
							<label>Arts:</label>					       
                            <input type="number" name="Arts" value="'.$rowdata['Arts'].'" class="form-control"  required>
							<label>P.E:</label>					       
                            <input type="number" name="PE" value="'.$rowdata['PE'].'" class="form-control"  required>
							<label>Health:</label>					       
                            <input type="number" name="Health" value="'.$rowdata['Health'].'"  class="form-control"  required>
							<label>RO Thematic:</label>					       
                            <input type="number" name="ROThematic" value="'.$rowdata['RO_Thematic'].'" class="form-control"  required>
							</div>';
							}
							echo '
					
							<label style="padding:10px;">
							</label>';
							
                 ?>          
		
</div>
<div class="modal-footer">
<input type="submit" class="btn btn-primary" name="update" value="UPDATE">
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="window.location.reload()">Close</button>
							
</div>
</form>
                                       