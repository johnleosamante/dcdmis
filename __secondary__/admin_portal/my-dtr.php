<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
	<h3 class="modal-title text-center">Daily Time Record</h3>
</div>

<div class="modal-body">
	<?php
	session_start();
	include("../pcdmis/vendor/jquery/function.php");
	$_SESSION['per_id'] = $_GET['id'];
	$emp_info = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position = tbl_job.Job_code WHERE tbl_employee.Emp_ID='" . $_GET['id'] . "'");
	$data = mysqli_fetch_assoc($emp_info);

	if ($data['Picture'] <> NULL) {
		echo  '<img src="../../pcdmis/images/' . $data['Picture'] . '" style="width:200px;height:200px;border-radius:5em;" align="left">';
	} else {
		echo  '<img src="../pcdmis/logo/user.png" style="width:200px;height:200px;border-radius:5em;" align="left">';
	}

	echo '<p>Employee ID: ' . $_GET['id'] . '</p>';
	echo '<p>Employee Name: ' . $data['Emp_LName'] . ', ' . $data['Emp_FName'] . ' ' . $data['Emp_MName'] . '</p>';
	echo '<p>Current Station: ' . $data['SchoolName'] . '</p>';
	echo  '<p>Birthdate: ' . $data['Emp_Month'] . '/' . $data['Emp_Day'] . '/' . $data['Emp_Year'] . '</p>';
	echo  '<p>Contact No.: ' . $data['Emp_Cell_No'] . '</p>';
	echo  '<p>Position: ' . $data['Job_description'] . '</p><hr/>';
	echo  '<p>Date From: ' . date('Y-m') . '-01 To ' . date('Y-m') . '-31  <a href="print-dtr.php?link=13b714fad9eca2a00fe69ce8ce03cba1c7e08527" style="float:right;" class="btn btn-primary" target="_blank">Print</a></p>';

	echo '<br/><table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr>
												<th width="5%" style="text-align:center;" rowspan="2">#</th>
												<th width="20%" rowspan="2">Date </th>
												<th width="30%" colspan="2" style="text-align:center;">Morning Session</th>
												<th width="30%" colspan="2" style="text-align:center;">Afternoon Session</th>
												
											</tr>
											<tr>
												<th style="text-align:center;">In</th>
												<th style="text-align:center;">Out</th>
												<th style="text-align:center;">In</th>
												<th style="text-align:center;">Out</th>
											
											
											</tr>										
									</thead>
									<tbody>';

	$no = 0;
	$myinfoDTR = mysqli_query($con, "SELECT * FROM tbl_dtr WHERE tbl_dtr.DTRDate BETWEEN '" . date('Y-m') . '-01' . "' AND '" . date('Y-m') . '-31' . "' AND tbl_dtr.Emp_ID='" . $_GET['id'] . "'");
	while ($row = mysqli_fetch_array($myinfoDTR)) {
		$no++;
		echo '<tr>
													<td style="text-align:center;">' . $no . '</td>
													<td style="text-align:center;">' . $row['DTRDate'] . '</td>
													<td style="text-align:center;">' . $row['TimeINAM'] . '</td>
													<td style="text-align:center;">' . $row['TimeOUTAM'] . '</td>
													<td style="text-align:center;">' . $row['TimeINPM'] . '</td>
													<td style="text-align:center;">' . $row['TimeOUTPM'] . '</td>
												</tr>';
	}

	echo '</tbody></table>'; ?>
</div>