<?php
session_start();
include("../../pcdmis/vendor/jquery/function.php");
foreach ($_GET as $key => $data)
{
	
$data2=$_GET[$key]=base64_decode(urldecode($data));
	
}
$_SESSION['upsched']=$data2;
 $emp_info=mysqli_query($con,"SELECT * FROM tbl_section INNER JOIN tbl_employee ON tbl_section.Emp_ID = tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_section.SchoolID='".$_SESSION['school_id']."' AND tbl_section.School_Year ='".$_SESSION['year']."' AND tbl_section.SecCode='".$_SESSION['sec_id']."' ORDER BY tbl_section.SecDesc Asc")or die ('Error Adding Section');
$data=mysqli_fetch_assoc($emp_info);
						
if ($data['Grade']==11 || $data['Grade']==12)
		{
			$mysub=mysqli_query($con,"SELECT * FROM tbl_senior_sub_strand INNER JOIN class_program ON tbl_senior_sub_strand.StrandsubCode =  class_program.SubNo WHERE tbl_senior_sub_strand.SubGradeLevel='".$data['Grade']."' AND class_program.No='".$_SESSION['upsched']."' LIMIT 1");
			
		}elseif ($data['Grade']>=7 AND $data['Grade']<=10){
			$mysub=mysqli_query($con,"SELECT * FROM tbl_jhs_subject INNER JOIN class_program ON tbl_jhs_subject.SubNo = class_program.SubNo WHERE class_program.No='".$_SESSION['upsched']."' LIMIT 1");	
		
		}else{
			
			$mysub=mysqli_query($con,"SELECT * FROM tbl_element_subject INNER JOIN class_program ON tbl_element_subject.SubNo = class_program.SubNo WHERE class_program.No='".$_SESSION['upsched']."' LIMIT 1");	
		}
		$getdata=mysqli_fetch_array($mysub);
echo '<div class="modal-header">
         
          <h3 class="modal-title"><center>Edit Section</center></h3>
		 
        </div><form action="" Method="POST" enctype="multipart/form-data">
        <div class="modal-body">
		
		<label>Subject</label>';
		
		echo ' <input type="text" name="sched_time" class="form-control" value ="'.$getdata['LearningAreas'].'"required>';
		
		echo '
		<label>Time:</label>
		 <input type="text" name="sched_time" class="form-control" value ="'.$getdata['SecTime'].'"required>
		<label style="padding:4px;">Day</label><br/>
		 <input type="text" name="sched_day" class="form-control" value ="'.$getdata['SecDay'].'" required>
		<label style="padding:4px;">Teacher</label><br/>
		<select name="subTeacher" class="form-control">
		';
			$myinfo=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_station.Emp_Station ='".$_SESSION['school_id']."' AND tbl_employee.Emp_Status ='Active' ORDER BY Emp_LName Asc")or die ("Retirees Information error");
			while($row=mysqli_fetch_array($myinfo))
				{
					echo '<option value="'.$row['Emp_ID'].'">'.$row['Emp_LName'].', '.$row['Emp_FName'].'</option>';		
				}
		echo '</select>
		
		</div>
		';
		?>
       
	<div class="modal-footer">
		<input type="submit" name="update_schedule" value="Save" class="btn btn-primary">
		 <button type="button" class="btn btn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
		 	</div>
		 </form>