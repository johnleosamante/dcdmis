<?php
if (isset($_POST['updatemyposition'])) {
	$query = mysqli_query($con, "SELECT * FROM tbl_deployment_history WHERE Emp_ID ='" . $_SESSION['EmpID'] . "' AND position_assign='" . $_POST['newposition'] . "' AND station_assign='" . $_SESSION['SchoolID'] . "'");

	if (mysqli_num_rows($query) == 0) {
		mysqli_query($con, "UPDATE tbl_station SET Emp_Position='" . $_POST['newposition'] . "' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
		mysqli_query($con, "INSERT INTO tbl_deployment_history(Date_assignment,station_assign,position_assign,No_of_years,StepNo,Emp_ID) VALUES('" . $_POST['date_of_assignment'] . "','" . $_SESSION['SchoolID'] . "','" . $_POST['newposition'] . "','0','1','" . $_SESSION['EmpID'] . "')");
	}

	if (mysqli_affected_rows($con) == 1) {
?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
	<?php
	}
} elseif (isset($_POST['updatemyappointment'])) {
	mysqli_query($con, "UPDATE tbl_station SET Emp_DOA='" . $_POST['DOA'] . "' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");

	if (mysqli_affected_rows($con) == 1) {
	?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#access').modal({
					show: 'true'
				});
			});
		</script>
<?php
	}
}
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h3 class="h4 mb-0">Request for Transfer</h3>

					<div class="d-inline-block">
						<a href="#newrequest" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">New Request</span></a>
					</div>
				</div>
			</div><!-- .card-header -->

			<div class="card-body">
				<div class="row">
					<div class="col table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr class="text-center">
									<th class="align-middle">#</th>
									<th class="align-middle">Date Requested</th>
									<th class="align-middle">Current school</th>
									<th class="align-middle">Years in service</th>
									<th class="align-middle">School to transfer</th>
									<th class="align-middle">Reason for Transfer</th>
									<th class="align-middle">Status</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center align-middle" colspan="7">No data available in table.</td>
								</tr>
							</tbody>
						</table>
					</div><!-- .col -->
				</div><!-- .row -->

				<div class="row">
					<div class="col-lg-4">
						<div class="panel-body">
							<?php
							$result = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
							$row = mysqli_fetch_assoc($result);
							$date = date('F j\, Y', strtotime($row['Emp_DOA']));
							$bdate = date('F j\, Y', strtotime($row['Emp_Month'] . '/' . $row['Emp_Day'] . '/' . $row['Emp_Year']));
							$age = date("Y") - $row['Emp_Year'];
							echo '<label>Name:</label><input type="text" class="form-control" value="' . $row['Emp_LName'] . ', ' . $row['Emp_FName'] . '" disabled>
	<label>Date of birth:</label><input type="text" class="form-control" value="' . $bdate . '"disabled>
	<label>Age:</label><input type="text" class="form-control" value="' . $age . '"disabled>
	<label>Contact Number:</label><input type="text" class="form-control" value="' . $row['Emp_Cell_No'] . '"disabled>
	<label>Address:</label><input type="text" class="form-control" disabled value="' . $row['Emp_Address'] . '">
	<label>Position:</label><input type="text" class="form-control"disabled value="' . $row['Job_description'] . '"><a href="#updateposition" data-toggle="modal">Change</a><br/>
	<label>Date of Original Appointment:</label><input type="text" class="form-control"disabled value="' . $date . '"><a href="#updateappointment" data-toggle="modal">Change</a>';
							?>
						</div>
					</div>

					<div class="col-lg-8">
						<h4>DEPLOYMENT HISTORY</h4>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th style="text-align:center;">#</th>
									<th>Date of Assignment</th>
									<th>School Assigned</th>
									<th>Years in service</th>
									<th>Position</th>
									<th>Subject Area</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 0;
								$myhistory = mysqli_query($con, "SELECT * FROM tbl_deployment_history INNER JOIN tbl_school ON tbl_deployment_history.station_assign = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_deployment_history.position_assign=tbl_job.Job_code WHERE tbl_deployment_history.Emp_ID='" . $_SESSION['EmpID'] . "'");
								while ($rowhist = mysqli_fetch_array($myhistory)) {
									$no++;
									echo '<tr>
					<td>' . $no . '</td>
					<td>' . $rowhist['Date_assignment'] . '</td>
					<td>' . $rowhist['SchoolName'] . '</td>
					<td style="text-align:center;">' . $rowhist['No_of_years'] . '</td>
					<td style="text-align:center;">' . $rowhist['Job_description'] . '</td>
					<td>' . $rowhist['SubjectArea'] . '</td>
				  </tr>';
								}
								?>
							</tbody>

						</table>
					</div>
				</div>
			</div><!-- .card-body -->
		</div><!-- .card -->
	</div><!-- .col -->
</div><!-- .row -->

<div class="modal fade" id="updateposition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">
					Update my position
				</h3>
			</div><!-- .modal-header -->

			<form action="" Method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<label>Select Position:</label>
					<select name="newposition" class="form-control" placeholder="Select Position" required>
						<option value="">--select--</option>
						<?php
						$mynewpost = mysqli_query($con, "SELECT * FROM tbl_job ORDER BY Job_description Asc");
						while ($rowpost = mysqli_fetch_array($mynewpost)) {
							echo '<option value="' . $rowpost['Job_code'] . '">' . $rowpost['Job_description'] . '</option>';
						}
						?>
					</select>
					<label>Date of Assignment:</label>
					<input type="date" name="date_of_assignment" class="form-control" required>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<input type="submit" name="updatemyposition" value="UPDATE" class="btn btn-primary">
					<button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->

<div class="modal fade" id="updateappointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">
					Update my Date of Original Appointment
				</h3>
			</div><!-- .modal-header -->

			<form action="" Method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<label>Date of Original Appointment:</label>
					<input type="date" name="DOA" class="form-control" required>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<input type="submit" name="updatemyappointment" value="UPDATE" class="btn btn-primary">
					<button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->

<div class="modal fade" id="newrequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">
					New Request for Transfer Information
				</h3>
			</div><!-- .modal-header -->

			<form action="" Method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<label>Date request:</label>
					<input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" disabled>
					<input type="hidden" name="DRT" class="form-control" value="<?php echo date("Y-m-d"); ?>">
					<label>Transfer to:</label>
					<input type="text" name="transferto" class="form-control" required>
					<label># of years render:</label>
					<input type="text" name="no_of_years" class="form-control" required>
					<label>Reason to Transfer:</label>
					<textarea name="reason_to_transfer" class="form-control" required rows="2"></textarea>
					<label>Subject Areas:</label>
					<input type="text" name="SubjectArea" class="form-control" required>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<input type="submit" name="newrequest" value="SENT" class="btn btn-primary">
					<button type="button" class="btn tbn-default" data-dismiss="modal" onclick="window.location.reload();">Close</button>
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->