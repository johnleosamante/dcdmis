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
					<h3 class="h4 mb-0">Transfer Request</h3>

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
						<?php
						$result = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID=tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
						$row = mysqli_fetch_assoc($result);
						$date = date('F j\, Y', strtotime($row['Emp_DOA']));
						$bdate = date('F j\, Y', strtotime($row['Emp_Month'] . '/' . $row['Emp_Day'] . '/' . $row['Emp_Year']));
						$age = date("Y") - $row['Emp_Year'];
						$job = $row['Job_description'];
						?>
						<h3 class="h4">Employee Information</h3>

						<div class="form-group">
							<label class="mb-0">Name:</label>
							<input type="text" class="form-control" value="<?php echo $row['Emp_LName'] . ', ' . $row['Emp_FName']; ?>" disabled>
						</div>

						<div class="row">
							<div class="col-7 col-xs-12">
								<div class="form-group">
									<label class="mb-0">Date of birth:</label>
									<input type="text" class="form-control" value="<?php echo $bdate; ?>" disabled>
								</div>
							</div>

							<div class="col-5 col-xs-12">
								<div class="form-group">
									<label class="mb-0">Age:</label>
									<input type="text" class="form-control" value="<?php echo $age; ?>" disabled>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="mb-0">Contact Number:</label>
							<input type="text" class="form-control" value="<?php echo $row['Emp_Cell_No']; ?>" disabled>
						</div>

						<div class="form-group">
							<label class="mb-0">Address:</label>
							<input type="text" class="form-control" disabled value="<?php echo $row['Emp_Address']; ?>">
						</div>

						<div class="form-group">
							<div class="d-sm-flex align-items-center justify-content-between">
								<label class="mb-0">Position:</label>
								<a class="d-inline-block small" href="#updateposition" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a>
							</div>

							<input type="text" class="form-control" disabled value="<?php echo $job; ?>">
						</div>

						<div class="form-group mb-0">
							<div class="d-sm-flex align-items-center justify-content-between">
								<label class="mb-0">Date of Original Appointment:</label>
								<a class="d-inline-block small" href="#updateappointment" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a>
							</div>

							<input type="text" class="form-control" disabled value="<?php echo $date; ?>">
						</div>
					</div>

					<div class="col-lg-8">
						<h3 class="h4">Deployment History</h3>
						<table width="100%" class="table table-striped table-bordered table-hover">
							<thead>
								<tr class="text-center">
									<th class="align-middle">#</th>
									<th class="align-middle">Date of Assignment</th>
									<th class="align-middle">School Assigned</th>
									<th class="align-middle">Years in service</th>
									<th class="align-middle">Position</th>
									<th class="align-middle">Subject Area</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 0;
								$myhistory = mysqli_query($con, "SELECT * FROM tbl_deployment_history INNER JOIN tbl_school ON tbl_deployment_history.station_assign = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_deployment_history.position_assign=tbl_job.Job_code WHERE tbl_deployment_history.Emp_ID='" . $_SESSION['EmpID'] . "'");

								if (mysqli_num_rows($myhistory) > 0) {
									while ($rowhist = mysqli_fetch_array($myhistory)) {
										$no++; ?>
										<tr class="text-center">
											<td class="align-middle"><?php echo $no; ?></td>
											<td class="align-middle"><?php echo $rowhist['Date_assignment']; ?></td>
											<td class="align-middle"><?php echo $rowhist['SchoolName']; ?></td>
											<td class="align-middle"><?php echo $rowhist['No_of_years']; ?></td>
											<td class="align-middle"><?php echo $rowhist['Job_description']; ?></td>
											<td class="align-middle"><?php echo $rowhist['SubjectArea']; ?></td>
										</tr>
									<?php
									}
								} else { ?>
									<tr>
										<td class="text-center align-middle" colspan="6">No data available in table.</td>
									</tr>
								<?php
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

<div class="modal fade" id="updateposition" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Position</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div><!-- .modal-header -->

			<form action="" Method="POST" role="form">
				<div class="modal-body">
					<div class="form-group">
						<label for="newposition" class="mb-0">Position:</label>
						<select id="newposition" name="newposition" class="form-control" placeholder="Select Position" required>
							<?php
							$mynewpost = mysqli_query($con, "SELECT * FROM tbl_job ORDER BY Job_description Asc");
							while ($rowpost = mysqli_fetch_array($mynewpost)) { ?>
								<option value="<?php echo $rowpost['Job_code']; ?>" <?php echo SetOptionSelected($job, $rowpost['Job_description']); ?>><?php echo $rowpost['Job_description']; ?></option>
							<?php
							}
							?>
						</select>
					</div>

					<div class="form-group mb-0">
						<label for="date_of_assignment" class="mb-0">Date of Assignment:</label>
						<input type="date" name="date_of_assignment" class="form-control" required>
					</div>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<input type="submit" name="updatemyposition" value="Update" class="btn btn-primary">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->

<div class="modal fade" id="updateappointment" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Date of Original Appointment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div><!-- .modal-header -->

			<form action="" Method="POST" role="form">
				<div class="modal-body">
					<input type="date" name="DOA" class="form-control" required>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<input type="submit" name="updatemyappointment" value="Update" class="btn btn-primary">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->

<div class="modal fade" id="newrequest" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">New Transfer Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
			</div><!-- .modal-header -->

			<form action="" Method="POST" role="form">
				<div class="modal-body">
					<div class="form-group">
						<label class="mb-0">Date of request:</label>
						<input type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" disabled>
						<input type="hidden" name="DRT" class="form-control" value="<?php echo date("Y-m-d"); ?>">
					</div>

					<div class="form-group">
						<label for="transferto" class="mb-0">Transfer to:</label>
						<input type="text" id="transferto" name="transferto" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="no_of_years" class="mb-0">Number of Years Rendered:</label>
						<input type="text" id="no_of_years" name="no_of_years" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="reason_to_transfer" class="mb-0">Reason for Transfer:</label>
						<textarea id="reason_to_transfer" name="reason_to_transfer" class="form-control" required rows="2"></textarea>
					</div>

					<div class="form-group mb-0">
						<label for="SubjectArea" class="mb-0">Subject Area:</label>
						<input type="text" id="SubjectArea" name="SubjectArea" class="form-control" required>
					</div>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<input type="submit" name="newrequest" value="OK" class="btn btn-primary">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->