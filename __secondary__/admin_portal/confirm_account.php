  <div class="modal-header">
  	<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
  	<h3 class="modal-title">
  		<center>ACCOUNT CONFIRMATION</center>
  	</h3>

  </div>
  <div class="modal-body">

  	<?php
		session_start();
		include("../pcdmis/vendor/jquery/function.php");
		foreach ($_GET as $key => $data) {
			$url = $_GET[$key] = base64_decode(urldecode($data));
		}
		$_SESSION['per_id'] = $url;
		$emp_info = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='" . $url . "'") or die("Error information data");
		$data = mysqli_fetch_assoc($emp_info);
		$_SESSION['SchoolID'] = $data['Emp_Station'];
		echo '<b>';
		if ($data['Picture'] <> NULL) {
			echo  '<img src="../' . $data['Picture'] . '" style="width:140px;height:140px;border-radius:5em;" align="right">';
		} else {
			echo  '<img src="../pcdmis/logo/user.png" style="width:140px;height:140px;border-radius:5em;" align="right">';
		}
		echo '<p>Employee ID: ' . $url . '</p>';
		echo '<p>Employee Name: ' . $data['Emp_LName'] . ', ' . $data['Emp_FName'] . ' ' . $data['Emp_MName'] . '</p>';
		echo '<p>Current Station: ' . $data['SchoolName'] . '</p>';
		echo  '<p>Birthdate: ' . $data['Emp_Month'] . '/' . $data['Emp_Day'] . '/' . $data['Emp_Year'] . '</p>';
		echo  '<p>Contact No.: ' . $data['Emp_Cell_No'] . '</p>';
		$maccount = mysqli_query($con, "SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='" . $data['Emp_Email'] . "' LIMIT 1");
		if (mysqli_num_rows($maccount) === 1) {
			$mrow = mysqli_fetch_assoc($maccount);
			echo  '<p>Last Signin: ' . $mrow['Last_login'] . '</p>';
		} ?>
  	<hr />
  	<a href="comfirm_data.php" class="btn btn-success">CONFIRM</a>
  </div>
  <!--//Password pattern
		required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"-->