<?php
if (isset($_POST['approve']))
{
    mysqli_query($con,"INSERT INTO tbl_employment_summary VALUES (NULL,'".date('Y-m-d')."','".$_POST['position']."','".$_POST['state']."','".$_POST['to_step']."','".$_POST['salary']."','".$_GET['Code']."')");
    mysqli_query($con,"INSERT INTO tbl_deployment_history VALUES (NULL,'".date('Y-m-d')."','".$_POST['station']."','".$_POST['position']."','0','".$_POST['to_step']."','".$_GET['Code']."')");
	mysqli_query($con,"DELETE FROM tbl_step_increment WHERE tbl_step_increment.Emp_ID='".$_GET['Code']."' LIMIT 1");
	if(mysqli_affected_rows($con)==1)
	{
		?>
			<script type="text/javascript">
				$(document).ready(function(){						
				$('#approval').modal({
					show: 'true'
				}); 				
				});
			</script>
									
							 
		<?php 
	}
}
?>

 <form action="" Method="POST" enctype="multipart/form-data">
 <div class="col-lg-4"> 
  <div class="panel panel-default">
    
	     <h4 style="padding:4px;margin:4px;text-transform:uppercase;text-align:center;">Information for Approval</h4><hr/>

    
    <div class="panel-body">
 <?php

   $result=mysqli_query($con,"SELECT * FROM tbl_step_increment INNER JOIN tbl_employee ON tbl_step_increment.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_step_increment.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['Code']."' LIMIT 1")or die ("Error query data");
   $getdata=mysqli_fetch_assoc($result);	
   $stepTo=$getdata['Step_No'];
	$stepTo++;
	$_SESSION['StepID']=$_GET['Code'];
	$myStep=mysqli_query($con,"SELECT * FROM tbl_salary_grade_level WHERE tbl_salary_grade_level.Salary_step='".$stepTo."' AND tbl_salary_grade_level.Salary_Grade='".$getdata['Salary_Grade']."' LIMIT 1");
	$myNewStep=mysqli_fetch_assoc($myStep);
	echo '<label>Employee Name</label>
		<input type="text" name="EmpName" value="'.$getdata['Emp_LName'].', '.$getdata['Emp_FName'].' '.$getdata['Emp_MName'].'" class="form-control" disabled>
		<label>Date</label>
		<input type="date" name="dpromotion" value="'.date('Y-m-d').'" class="form-control" disabled>
		<input type="hidden" name="dpromotion" value="'.date('Y-m-d').'" class="form-control">
		<label>Position</label>
		<input type="text" value="'.$getdata['Job_description'].'" class="form-control" disabled>
		<input type="hidden" name="position" value="'.$getdata['Job_code'].'" class="form-control">
		<label>Station</label>
		<input type="text"  value="'.$getdata['Abraviate'].'" class="form-control" disabled>
		<input type="hidden" name="station" value="'.$getdata['SchoolID'].'" class="form-control">
		<label>From Step</label>
		<input type="text"  value="'.$getdata['Step_No'].'" class="form-control" disabled>
		<input type="hidden" name="from_step" value="'.$getdata['Step_No'].'" class="form-control">
		<label>To Step</label>
		<input type="text"  value="'.$stepTo.'" class="form-control" onchange="showSchool(this.value)" disabled>
		<input type="hidden" name="to_step" value="'.$stepTo.'" class="form-control">
		<label>Salary</label>
		<input type="text" name="salary" class="form-control" value="'.number_format($myNewStep['Salary_amount'],2).'" disabled>
		<input type="hidden" name="salary" class="form-control" value="'.$myNewStep['Salary_amount'].'"><hr/>
		<input type="submit" name="approve" value="Approved" class="btn btn-primary">
		<a href="./" class="btn btn-default" >Close</a>';
		
	
 ?>
   </div>
 </div>
 </div>
 
 <div class="col-lg-8"> 
  <div class="panel panel-default">
	     <h4 style="padding:4px;margin:4px;text-transform:uppercase;text-align:center;">Required Attachment</h4><hr/>
    <div class="panel-body">
		<div class="col-lg-12"> 
		
		 <?php
			$querypayslip=mysqli_query($con,"SELECT * FROM tbl_step_requirements WHERE RequiredFor ='STEP' AND Emp_ID='".$_GET['Code']."' AND RequiredDocument='PAYSLIP' AND RequiredYear='".$_SESSION['year']."'LIMIT 1");
			$queryslip=mysqli_fetch_assoc($querypayslip);
			if(mysqli_num_rows($querypayslip)==1)
				 {								 
					echo '<h4>Payslip for 2 consecutive months</h4><hr/>';
					echo '<iframe src="../'.$queryslip['DocLocation'].'" frameborder="0" style="width:100%;height:450px;"></iframe>';
				 }
		?>	
		</div>
		<div class="col-lg-12"> 
		   <?php
				$queryappointment=mysqli_query($con,"SELECT * FROM tbl_step_requirements WHERE RequiredFor ='STEP' AND Emp_ID='".$_GET['Code']."' AND RequiredDocument='APPOINTMENT' AND RequiredYear='".$_SESSION['year']."'LIMIT 1");
				$queryapoint=mysqli_fetch_assoc($queryappointment);
				if(mysqli_num_rows($queryappointment)==1)
					{								 
					echo '<h4>Latest Appointment</h4>';
					echo '<img src="../'.$queryapoint['DocLocation'].'"  style="width:100%;height:450px;">';
					}
			?>		
		 
		</div>
		<div class="col-lg-12"> 
		   <?php
				$queryappointment=mysqli_query($con,"SELECT * FROM tbl_step_requirements WHERE RequiredFor ='STEP' AND Emp_ID='".$_GET['Code']."' AND RequiredDocument='SERVICE RECORD' AND RequiredYear='".$_SESSION['year']."'LIMIT 1");
				$queryapoint=mysqli_fetch_assoc($queryappointment);
				 if(mysqli_num_rows($queryappointment)==1)
					{								 
						echo '<h4>Updated Service Record</h4>';
						echo '<img src="../'.$queryapoint['DocLocation'].'"  style="width:100%;height:450px;">';
					}
			?>		
		 
		</div>
	</div>
  </div>
 </div>
 
 </form>
 
 
 
              <!-- Modal -->
	 <div class="modal fade" id="approval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	 <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
	
			<div class="modal-header">
			<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Confirm</h4>
			</div>
			 
			<div class="modal-body">
			<img src="../../pcdmis/logo/check.png" width="100%" height="50%">
			<center><h3>Successfully Submitted!</h3></center>
		   	</div>
           <div class="modal-footer">
		   <a href="./" class="btn btn-success">Continue...</a>
			</center>
		 </div>	

	</div></div>
	</div>
 