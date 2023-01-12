<?php
$showPrompt = false;

if (isset($_POST['savelocator'])) {
	mysqli_query($con, "INSERT INTO tbl_locator_passslip VALUES('" . date("ydms") . "','" . $_POST['category'] . "','" . date("Y-m-d") . "','" . $_POST['purpose'] . "','" . $_POST['timeleaving'] . "','" . $_POST['timereturn'] . "','" . $_POST['signature'] . "','For Approval','" . $_SESSION['EmpID'] . "')");

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
					<h3 class="h4 mb-0">Locator</h3>

					<div class="d-inline-block">
						<a href="#newLocatorModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fas fa-plus fa-fw"></i></span><span class="text">Add</span></a>
					</div>
				</div>
			</div>

			<div class="card-body">
				<?php
				if ($showPrompt) {
					AlertBox('Locator has been added successfuly!', 'success', 'left');
				}
				?>

				<div class="row">
					<div class="col table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover mb-0">
							<thead>
								<tr class="text-center">
									<th class="align-middle" width="5%">#</th>
									<th class="align-middle" width="10%">Date</th>
									<th class="align-middle" width="10%">Purpose</th>
									<th class="align-middle" width="25%">Reason</th>
									<th class="align-middle" width="10%">Departure Time</th>
									<th class="align-middle" width="10%">Arrival Time</th>
									<th class="align-middle" width="15%">Immediate Supervisor</th>
									<th class="align-middle" width="15%">Status</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$no = 0;
								$result = mysqli_query($con, "SELECT * FROM tbl_locator_passslip WHERE Emp_ID='" . $_SESSION['EmpID'] . "'");
								while ($row = mysqli_fetch_array($result)) {
									$no++; ?>
									<tr>
										<td class="align-middle text-center"><?php echo $no; ?></td>
										<td class="align-middle text-center"><?php echo GetDateString($row['dateout']); ?></td>
										<td class="align-middle text-center"><?php echo $row['Category']; ?></td>
										<td class="align-middle"><?php echo $row['Purpose']; ?></td>
										<td class="align-middle text-center"><?php echo $row['TimeLeaving']; ?></td>
										<td class="align-middle text-center"><?php echo $row['TimeReturn']; ?></td>
										<td class="align-middle"><?php echo $row['Approvedby']; ?></td>
										<td class="align-middle text-center"><?php echo $row['RequestStatus']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div><!-- .col -->
				</div><!-- .row -->
			</div><!-- .card-body -->
		</div><!-- .card -->
	</div><!-- .col -->
</div><!-- .row -->

<div class="modal fade" id="newLocatorModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Locator Slip</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div><!-- .modal-header -->

			<form action="" Method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label for="category" class="mb-0">Purpose:</label>
						<select id="category" name="category" class="form-control" required>
							<option value="Official">Official</option>
							<option value="Personal">Personal</option>
						</select>
					</div>

					<div class="form-group">
						<label for="purpose" class="mb-0">Reason:</label>
						<textarea id="purpose" name="purpose" class="form-control" rows="3" required></textarea>
					</div>

					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label for="timeleaving" class="mb-0">Departure Time:</label>
								<input id="timeleaving" type="time" name="timeleaving" class="form-control" required>
							</div>
						</div>

						<div class="col-6">
							<label for="timereturn" class="mb-0">Arrival Time:</label>
							<input id="timereturn" type="time" name="timereturn" class="form-control" required>
						</div>
					</div>

					<div class="form-group mb-0">
						<label for="station" class="mb-0">Section Assigned:</label>
						<select id="station" class="form-control" onchange="viewdata(this.value)" required>
							<option value="">Select Section</option>
							<?php
							$sig = mysqli_query($con, "SELECT * FROM tbl_office WHERE Office_Name <>'SCHOOL' ORDER BY Office_Name Asc");
							while ($rowsig = mysqli_fetch_array($sig)) : ?>
								<option value="<?php echo $rowsig['Office_Name']; ?>"><?php echo $rowsig['Office_Name']; ?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group mb-0" id="signate"></div>
				</div><!-- .modal-body -->

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="submit" name="savelocator" class="btn btn-primary">Save</button>
				</div><!-- .modal-footer -->
			</form>
		</div><!-- .modal-content -->
	</div><!-- .modal-dialog -->
</div><!-- .modal -->

<script>
	function viewdata(str) {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("signate").innerHTML = xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "locator/immediate-supervisor.php?id=" + str, false);
		xmlhttp.send();
	}
</script>