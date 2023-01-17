<?php
$showPrompt = false;

if (isset($_POST['send'])) {
	$query = mysqli_query($con, "SELECT * FROM tbl_deped_reset_account WHERE DateRequest='" . date("Y-m-d") . "' AND Remarks='" . $_POST['purpose'] . "' AND SchoolID='" . $_SESSION['SchoolID'] . "' AND Emp_ID='" . $_SESSION['EmpID'] . "'");

	if (mysqli_num_rows($query) == 0) {
		mysqli_query($con, "INSERT INTO tbl_deped_reset_account  VALUES('" . date("ydmis") . "','" . date("Y-m-d") . "','" . $_SESSION['EmpID'] . "','" . $_POST['EmailAdd'] . "','" . $_SESSION['SchoolID'] . "','" . $_POST['ContactNo'] . "','" . $_POST['purpose'] . "')");
	}

	if (mysqli_affected_rows($con) === 1) {
		$showPrompt = true;
	}
}
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h3 class="h4 mb-0">DepEd Account Request</h3>

					<a href="#newAccountRequestModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fa fa-plus fa-fw"></i></span><span class="text">New Request</span></a>
				</div>
			</div>

			<div class="card-body">
				<?php
				if ($showPrompt) {
					AlertBox('New DepEd account request has been submitted successfully!', 'success', 'left');
				}
				?>

				<div class="table-responsive">
					<table width="100%" class="table table-striped table-bordered table-hover mb-0">
						<thead>
							<tr class="text-center">
								<th class="align-middle" width="10%">Ticket #</th>
								<th class="align-middle" width="10%">Date Requested</th>
								<th class="align-middle" width="15%">DepEd Email</th>
								<th class="align-middle" width="25%">School Assigned</th>
								<th class="align-middle" width="15%">Contact No.</th>
								<th class="align-middle" width="15%">Status</th>
								<th class="align-middle" width="10%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 0;
							$myhistory = mysqli_query($con, "SELECT * FROM tbl_deped_reset_account INNER JOIN tbl_school ON tbl_deped_reset_account.SchoolID = tbl_school.SchoolID WHERE tbl_deped_reset_account.Emp_ID='" . $_SESSION['EmpID'] . "'");

							if (mysqli_num_rows($myhistory) > 0) {
								while ($rowhist = mysqli_fetch_array($myhistory)) { ?>
									<tr class="text-center">
										<td class="align-middle"><?php echo $rowhist['TicketNo']; ?></td>
										<td class="align-middle"><?php echo ToDateString($rowhist['DateRequest']); ?></td>
										<td class="align-middle"><?php echo $rowhist['depedemail']; ?></td>
										<td class="align-middle"><?php echo $rowhist['SchoolName']; ?></td>
										<td class="align-middle"><?php echo $rowhist['ContactNo']; ?></td>
										<td class="align-middle"><?php echo $rowhist['Remarks']; ?></td>
										<td class="align-middle"><a class="btn btn-success my-1" onclick="viewdata('viewinfo', 'deped-account-request/view-account-request.php?id=<?php echo $rowhist['TicketNo']; ?>')" data-toggle="modal" data-target="#viewinfo" title="View"><i class="fas fa-eye fa-fw"></i></a></td>
									</tr>
								<?php
								}
							} else { ?>
								<tr>
									<td class="text-center align-middle" colspan="7">No data available in table.</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="newAccountRequestModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">DepEd Account Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form action="" method="POST" role="form">
				<div class="modal-body">
					<div class="form-group">
						<label class="mb-0">Name:</label>
						<input type="text" class="form-control" value="<?php echo $_SESSION['TeacherName']; ?>" disabled>
					</div>

					<div class="form-group">
						<label for="EmailAdd" class="mb-0">DepEd Emai:</label>
						<input id="EmailAdd" type="email" class="form-control" name="EmailAdd" required>
					</div>

					<div class="form-group">
						<label for="ContactNo" class="mb-0">Contact No:</label>
						<input id="ContactNo" type="number" class="form-control" name="ContactNo" required>
					</div>

					<div class="form-group mb-0">
						<label for="purpose" class="mb-0">Purpose:</label>
						<select id="purpose" class="form-control" name="purpose" required>
							<option value="New Account">New Account</option>
							<option value="Reset Account">Reset Account</option>
						</select>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<input type="submit" name="send" value="OK" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="viewinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"></div><!-- .modal -->