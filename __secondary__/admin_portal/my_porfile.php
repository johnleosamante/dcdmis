 <style>
 #myProgress {
  width: 100%;
 text-align:center;
 border:solid 1px black;
 
}

#myBar {
  height: 30px;
  background-color: #4CAF50;
 
}
</style> 
  <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
          <h3 class="modal-title"><center>Personnel Profile Status</center></h3>
		 
        </div>
        <div class="modal-body">
		
		<?php
			session_start();
			include("../vendor/jquery/function.php");
			foreach ($_GET as $key => $data)
			{
			$data2=$_GET[$key]=base64_decode(urldecode($data));
				
			}
					$emp_info=mysqli_query($con,"SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='".$data2."'")or die("Error information data"); 
					 $data=mysqli_fetch_assoc($emp_info);
					 $_SESSION['EmpID']=$data2;
					 echo '<img src="'.$data['Picture'].'" width="100" height="100"   style="padding:4px;margin:4px;border-radius:10px;" align="right">';
					 echo '<label>Employee ID: '.$data2.'</label><br/>';
					 echo '<label>Employee Name: '.utf8_encode($data['Emp_LName'].', '.$data['Emp_FName'].' '.$data['Emp_MName']).'</label><br/>';
					 echo '<label>Station: '.$data['SchoolName'].'</label><br/>';
					 echo '<label>Birthdate: '.$data['Emp_Month'].'/'.$data['Emp_Day'].'/'.$data['Emp_Year'].'</label><br/>';
					 $hist=mysqli_query($con,"SELECT * FROM tbl_deployment_history WHERE tbl_deployment_history.Emp_ID='".$data2."'");
					 $data_hist=mysqli_fetch_assoc( $hist);
					 echo '<label>Lenght of Years: '. $data_hist['No_of_years'].'</label><hr/>';

		$total=$fam=$educ=$civil=$work=$volun=$learn=$other=$ref=0;
		
		$family_data=mysqli_query($con,"SELECT * FROM family_background WHERE family_background.Emp_ID='".$data2."'");
		if (mysqli_num_rows($family_data)<>0)
		{
			$fam=10;
		}
		$educ_data=mysqli_query($con,"SELECT * FROM educational_background WHERE educational_background.Emp_ID='".$data2."'");
		if (mysqli_num_rows($educ_data)<>0)
		{
			$educ=15;
		}
		$civil_data=mysqli_query($con,"SELECT * FROM civil_service WHERE civil_service.Emp_ID='".$data2."'");
		if (mysqli_num_rows($civil_data)<>0)
		{
			$civil=15;
		}
		$work_data=mysqli_query($con,"SELECT * FROM work_experience WHERE work_experience.Emp_ID='".$data2."'");
		if (mysqli_num_rows($work_data)<>0)
		{
			$work=5;
		}
		$voluntary_data=mysqli_query($con,"SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID='".$data2."'");
		if (mysqli_num_rows($voluntary_data)<>0)
		{
			$volun=5;
		}
		$learning_data=mysqli_query($con,"SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='".$data2."'");
		if (mysqli_num_rows($learning_data)<>0)
		{
			$learn=20;
		}
		$other_data=mysqli_query($con,"SELECT * FROM other_information WHERE other_information.Emp_ID='".$data2."'");
		if (mysqli_num_rows($other_data)<>0)
		{
			$other=10;
		}
		$reference_data=mysqli_query($con,"SELECT * FROM reference WHERE reference.Emp_ID='".$data2."'");
		if (mysqli_num_rows($reference_data)<>0)
		{
			$ref=20;
		}
		
		$total=$fam+$educ+$civil+$work+$volun+$learn+$other+$ref;
		echo '<div id="myProgress">
			<div id="myBar" style="width:'.$total.'%;color:white;">'.$total.'%</div>
		</div>';
		
		?>
		