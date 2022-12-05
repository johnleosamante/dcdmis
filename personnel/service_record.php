<?php
# personnel/service_record.php
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h3 class="h4 mb-0">Service Record</h3>
					<a href="<?php echo GetSiteURL(); ?>/personnel/print_service_record/" class="btn btn-primary btn-icon-split btn-sm" target="_blank"><span class="icon text-white-50"><i class="fas fa-print fa-fw"></i></span><span class="text">Print Preview</span></a>
				</div>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTable" cellspacing="0">
						<thead>
							<tr>
								<th class="text-center align-middle" colspan="2">Service Record</th>
								<th class="text-center align-middle" colspan="3">Record of Appointment</th>
								<th class="text-center align-middle" colspan="2">Office Entity/Division</th>
								<th class="text-center align-middle" rowspan="2">V/L Absences w/o Pay</th>
								<th class="text-center align-middle" rowspan="2">Separation</th>
							</tr>
							<tr>
								<th class="text-center align-middle">From</th>
								<th class="text-center align-middle">To</th>
								<th class="text-center align-middle">Designation</th>
								<th class="text-center align-middle">Status</th>
								<th class="text-center align-middle">Salary</th>
								<th class="text-center align-middle">Station/Place of Assignment</th>
								<th class="text-center align-middle">Branch</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$result = mysqli_query($con, "SELECT * FROM tbl_service_records WHERE tbl_service_records.Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY tbl_service_records.date_to Asc");
							while ($row = mysqli_fetch_array($result)) {

								echo '<tr>
													<td>' . $row['date_from'] . '</td>
													<td>' . $row['date_to'] . '</td>
													<td>' . $row['position'] . '</td>
													<td>' . $row['work_status'] . '</td>
													<td>' . number_format($row['salary'], 2) . '</td>
													<td>' . $row['station'] . '</td>
													<td>' . $row['branch'] . '</td>
													<td>' . $row['pay_status'] . '</td>
													<td>' . $row['separation'] . '</td>';

								echo '</tr>';
							}

							?>
						</tbody>

						<thead>
							<tr>
								<th class="text-center align-middle">From</th>
								<th class="text-center align-middle">To</th>
								<th class="text-center align-middle">Designation</th>
								<th class="text-center align-middle">Status</th>
								<th class="text-center align-middle">Salary</th>
								<th class="text-center align-middle">Station/Place of Assignment</th>
								<th class="text-center align-middle">Branch</th>
								<th class="text-center align-middle">V/L Absences w/o Pay</th>
								<th class="text-center align-middle">Separation</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>