<?php
# personnel/settings.php
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<?php ContentTitle('General Account Settings'); ?>
			</div>

			<div class="card-body">
				<?php
				if (isset($_POST['UpdatePosition'])) {
					DBNonQuery("UPDATE tbl_station SET Emp_Position='" . $_POST['position'] . "' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1;");

					if (DBAffectedRows($con) === 1) {
						AlertBox('Position has been updated successfully!', 'success', 'left');
					}

					$_SESSION['settingstab'] = 'user-information';
				}

				if (isset($_POST['UpdateTIN'])) {
					DBNonQuery("UPDATE tbl_employee SET Emp_TIN='" . $_POST['myTIN'] . "' WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1;");

					if (DBAffectedRows($con) === 1) {
						AlertBox('Tax Identification Number (TIN) has been updated successfully!', 'success', 'left');
					}

					$_SESSION['settingstab'] = 'user-information';
				}

				if (isset($_POST['UpdatePassword'])) {
					if ($_POST['password'] <> $_POST['confirm']) {
						AlertBox('Password do not match! Try again.', 'danger', 'left');
					} else {
						$pass = GetHashPassword(DBRealEscapeString($_POST['password']));

						DBNonQuery("UPDATE tbl_teacher_account SET Teacher_Password='$pass' WHERE tbl_teacher_account.Teacher_TIN='" . $_SESSION['Email'] . "' LIMIT 1;");

						$rec = DBQuery("SELECT * FROM tbl_user WHERE usercode='" . $_SESSION['EmpID'] . "'");

						if (DBNumRows($rec) === 1) {
							DBNonQuery("UPDATE tbl_user SET password='$pass' WHERE usercode='" . $_SESSION['EmpID'] . "'");
						}

						AlertBox('Password has been updated successfully!', 'success', 'left');
					}

					$_SESSION['settingstab'] = 'security-login';
				}

				/* PSIPOP */
				if (isset($_POST['UpdatePSIPOP'])) {
					$query = mysqli_query($con, "SELECT * FROM psipop WHERE Emp_ID='" . $_SESSION['EmpID'] . "';");

					if (mysqli_num_rows($query) == 0) {
						mysqli_query($con, "UPDATE tbl_station SET Emp_Position ='" . $_POST['position'] . "'  WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1");
						mysqli_query($con, "INSERT INTO psipop VALUES(NULL,'" . $_POST['item_number'] . "','" . $_POST['SN'] . "','" . $_POST['jobstatus'] . "','" . $_POST['DOA'] . "','" . $_POST['elegibility'] . "','" . $_SESSION['EmpID'] . "')");
					}

					if (DBAffectedRows($con) === 1) {
						AlertBox('PSIPOP has been updated successfully!', 'success', 'left');
					}

					$_SESSION['settingstab'] = 'psipop';
				}
				?>

				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(!isset($_SESSION['settingstab']) || $_SESSION['settingstab'] === 'user-information'); ?>" href="#user-information" data-toggle="tab">User Information</a>
					</li>

					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['settingstab']) && $_SESSION['settingstab'] === 'security-login'); ?>" href="#security-login" data-toggle="tab">Security and Login</a>
					</li>

					<li class="nav-item">
						<a class="nav-link text-secondary<?php echo SetActiveNavigationItem(isset($_SESSION['settingstab']) && $_SESSION['settingstab'] === 'psipop'); ?>" href="#psipop" data-toggle="tab">PSIPOP</a>
					</li>
				</ul><!-- .nav-tabs -->

				<div class="tab-content pt-2 px-2">
					<?php
					include_once('settings/user-information.php');
					include_once('settings/security-login.php');
					include_once('settings/psipop.php');
					?>
				</div><!-- .tab-content -->
			</div><!-- .card-body -->
		</div><!-- .card -->
	</div><!-- .col -->
</div><!-- .row -->