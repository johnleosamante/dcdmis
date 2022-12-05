  <?php
  session_start();
  include("../vendor/jquery/function.php");
   $result=mysqli_query($con,"SELECT * FROM tbl_step_increment INNER JOIN tbl_employee ON tbl_step_increment.Emp_ID=tbl_employee.Emp_ID INNER JOIN tbl_station ON tbl_step_increment.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$_GET['id']."' LIMIT 1")or die ("Error query data");
   $getdata=mysqli_fetch_assoc($result);	
		$stepTo=$getdata['Step_No'];
		$stepTo++;
		$_SESSION['StepID']=$_GET['id'];
		
		$myStep=mysqli_query($con,"SELECT * FROM tbl_salary_data WHERE tbl_salary_data.Salary_step='".$stepTo."' AND tbl_salary_data.Salary_Grade='". $getdata['Salary_Grade']."' LIMIT 1");
		$myNewStep=mysqli_fetch_assoc($myStep);
 echo  '<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()">&times;</button>
          <h3 class="modal-title"><center>Information for Approval</center></h3>
		 
        </div>
        <div class="modal-body">
		<form action="save_step_approaval.php" Method="POST">
		<label>Employee Name</label>
		<input type="text" name="EmpName" value="'.$getdata['Emp_LName'].', '.$getdata['Emp_FName'].' '.$getdata['Emp_MName'].'" class="form-control" disabled>
		<label>Date</label>
		<input type="date" name="dpromotion" value="'.date('Y-m-d').'" class="form-control" disabled>
		<input type="hidden" name="dpromotion" value="'.date('Y-m-d').'" class="form-control">
		<label>Position</label>
		<input type="text" name="promotion" value="'.$getdata['Job_description'].'" class="form-control" disabled>
		<input type="hidden" name="position" value="'.$getdata['Job_code'].'" class="form-control">
		<label>Station</label>
		<input type="text" name="station" value="'.$getdata['Abraviate'].'" class="form-control" disabled>
		<input type="hidden" name="state" value="'.$getdata['SchoolID'].'" class="form-control">
		<label>From Step</label>
		<input type="text" name="from_step" value="'.$getdata['Step_No'].'" class="form-control" disabled>
		<input type="hidden" name="from_step" value="'.$getdata['Step_No'].'" class="form-control">
		<label>To Step</label>
		<input type="text" name="to_step" value="'.$stepTo.'" class="form-control" onchange="showSchool(this.value)" disabled>
		<input type="hidden" name="to_step" value="'.$stepTo.'" class="form-control">
		<label>Salary</label>
		<input type="text" name="salary" class="form-control" value="'.number_format($myNewStep['Salary_amount'],2).'" disabled>
		<input type="hidden" name="salary" class="form-control" value="'.$myNewStep['Salary_amount'].'"><hr/>
		<input type="submit" name="approve" value="Approved" class="btn btn-primary">
        </form>
		</div>';
		?>
	 