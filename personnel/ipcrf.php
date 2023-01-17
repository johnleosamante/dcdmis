<?php
$showPrompt = false;

if (isset($_POST['AddScore'])) {
	$query = mysqli_query($con, "SELECT * FROM tbl_ipcrf_consolidated WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND SchoolYear='" . $_POST['sy'] . "'");

	if (mysqli_num_rows($query) == 0) {
		mysqli_query($con, "UPDATE tbl_station SET Emp_Position='" . $_POST['position'] . "' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
		mysqli_query($con, "INSERT INTO tbl_ipcrf_consolidated (Emp_ID,RatingScore,RatingAdjective,Position,SchoolID,SchoolYear)VALUES('" . $_SESSION['EmpID'] . "','" . $_POST['rating'] . "','" . $_POST['remarks'] . "','" . $_POST['position'] . "','" . $_SESSION['SchoolID'] . "','" . $_POST['sy'] . "')") or die("Hello");

		if (mysqli_affected_rows($con) == 1) {
			$showPrompt = true;
		}
	}
}
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h3 class="h4 mb-0">Individual Performance Commitment &amp; Review Form</h3>

					<div class="d-inline-block">
						<a href="#newIPCRFModal" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>

						<a href="" target="_blank" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-print fa-fw"></i></span><span class="text">Print Preview</span></a>
					</div>
				</div>
			</div>

			<div class="card-body">
				<?php
				if ($showPrompt) {
					AlertBox('IPCRF Rating has been successfully added!', 'success', 'left');
				}
				?>

				<div class="row">
					<div class="col table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover mb-0">
							<thead>
								<tr class="text-center">
									<th width="10%" class="align-middle">#</th>
									<th width="35%" class="align-middle">Station </th>
									<th width="10%" class="align-middle">School Year </th>
									<th width="15%" class="align-middle">Position </th>
									<th width="10%" class="align-middle">Rating</th>
									<th width="10%" class="align-middle">Remarks</th>
								</tr>

							</thead>
							<tbody>
								<?php
								$no = 0;
								$result = mysqli_query($con, "SELECT * FROM tbl_ipcrf_consolidated INNER JOIN tbl_school_year ON tbl_ipcrf_consolidated.SchoolYear = tbl_school_year.SYCode INNER JOIN tbl_job ON tbl_ipcrf_consolidated.Position=tbl_job.Job_code INNER JOIN tbl_school ON tbl_ipcrf_consolidated.SchoolID =tbl_school.SchoolID  WHERE tbl_ipcrf_consolidated.Emp_ID='" . $_SESSION['EmpID'] . "'");

								if (mysqli_num_rows($result) > 0) {
									while ($rowdata = mysqli_fetch_array($result)) {
										$no++; ?>
										<tr class="text-center">
											<td class="align-middle"><?php echo $no; ?></td>
											<td class="align-middle"><?php echo $rowdata['SchoolName']; ?></td>
											<td class="align-middle"><?php echo $rowdata['SchoolYear']; ?></td>
											<td class="align-middle"><?php echo $rowdata['Job_description']; ?></td>
											<td class="align-middle"><?php echo $rowdata['RatingScore']; ?></td>
											<td class="align-middle"><?php echo $rowdata['RatingAdjective']; ?></td>
										</tr>
									<?php
									}
								} else { ?>
									<tr>
										<td class="text-center align-middle" colspan="6">No data available in table</td>
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
</div>

<div class="modal fade" id="newIPCRFModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="" Method="POST" role="form">
				<div class="modal-header">
					<h5 class="modal-title">IPCRF</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div><!-- .modal-header -->

				<div class="modal-body">
					<div class="form-group">
						<label for="position" class="mb-0">Position:</label>
						<select id="position" name="position" class="form-control" required>
							<option value="">--Select--</option>
							<?php
							$myjob = mysqli_query($con, "SELECT * FROM tbl_job ORDER BY Job_description Asc");
							while ($rowjob = mysqli_fetch_array($myjob)) { ?>
								<option value="<?php echo $rowjob['Job_code']; ?>"><?php echo $rowjob['Job_description']; ?></option>
							<?php
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label for="rating" class="mb-0">Rating:</label>
						<input id="rating" type="text" name="rating" class="form-control" required>
					</div>

					<div class="form-group">
						<label for="remarks" class="mb-0">Remarks:</label>
						<select id="remarks" name="remarks" class="form-control" required>
							<option value="Outstanding">Outstanding</option>
							<option value="Very Satisfactory">Very Satisfactory</option>
							<option value="Satisfactory">Satisfactory</option>
							<option value="Unsatisfactory">Unsatisfactory</option>
							<option value="Poor">Poor</option>
						</select>
					</div>

					<div class="form-group mb-0">
						<label for="sy" class="mb-0">School Year</label>
						<select id="sy" name="sy" class="form-control" required>
							<option value="">--Select--</option>
							<?php
							$myyear = mysqli_query($con, "SELECT * FROM tbl_school_year ORDER BY SYCode Desc");
							while ($rowyear = mysqli_fetch_array($myyear)) { ?>
								<option value="<?php echo $rowyear['SYCode']; ?>"><?php echo $rowyear['SchoolYear']; ?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<input type="submit" name="AddScore" value="Save" class="btn btn-primary">
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->