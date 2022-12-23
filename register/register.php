<?php
# register/register.php
?>

<div class="col-lg-6">
	<div class="card shadow-lg border-0 rounded-lg my-5">
		<div class="card-header">
			<?php SiteLogo(120, 120); ?>
			<h3 class="text-center">Register Account</h3>
		</div><!-- .card-header -->

		<div class="card-body">
			<?php
			include_once('../_includes_/database/database.php');

			$success = false;

			if (isset($_POST['create_account'])) {
				$dateposted = GetDateTime();
				$age = "";
				$employeeID = GetDateTimeAsID();
				$empLName = str_replace("'", "\'", $_POST['LName']);
				$empFName = str_replace("'", "\'", $_POST['FName']);
				$empMName =  str_replace("'", "\'", $_POST['MName']);
				$empExt = str_replace("'", "\'", $_POST['Extension']);
				$empSex = $_POST['sex'];
				$empBMonth = $_POST['month'];
				$empBDay = $_POST['day'];
				$empBYear = $_POST['year'];
				$empContact = $_POST['contactNo'];
				$empEmail = $_POST['inputEmail'];
				$empPosition = $_POST['position'];
				$empSchool = $_POST['School'];
				$empImage = "assets/img/user.png";
				$start = date('Y');

				if ((!empty($_POST['password']) && !empty($_POST['repass'])) && ($_POST['password'] === $_POST['repass'])) {
					include_once('../_includes_/database/employee.php');

					$employees = GetEmployeeName($empLName, $empFName, $empMName, $empExt);

					if (DBNumRows($employees) === 0) {
						InsertEmployee($employeeID, $empLName, $empFName, $empMName, $empExt, $empBMonth, $empBDay, $empBYear, '', $empSex, '', '', '', '', '', '', $empContact, $empEmail, $empImage, '', 'Registered', '-', '', '');
						include_once('../_includes_/database/station.php');
						InsertStation('-', $empPosition, $empSchool, '-', '-', $age, $employeeID);
						include_once('../_includes_/database/deployment-history.php');
						InsertDeploymentHistory('-', $empSchool, $empPosition, '0', '', '', $employeeID, '', '');
						include_once('../_includes_/database/step-increment.php');
						InsertStepIncrement($start, '1', '0', $employeeID);
					}

					include_once('../_includes_/database/teacher-account.php');

					$user = GetTeacherAccount($empEmail);
					$pass = GetHashPassword($_POST['password']);

					if (DBNumRows($user) === 1) {
						UpdateTeacherAccountPassword($empEmail, $pass);
					} else {
						InsertTeacherAccount($empEmail, $pass, 'Offline', 'Default', $dateposted);
					}

					if (DBAffectedRows() === 1) {
						$success = true;
					}
				} else {
					AlertBox('Password do not match! Try again.');
				}
			} else {
				$empLName = '';
				$empFName = '';
				$empMName =  '';
				$empExt = '';
				$empBMonth = strtolower(date('m'));
				$empBDay = strtolower(date('d'));
				$empBYear = strtolower(date('Y'));
				$empSex = '';
				$empContact = '';
				$empEmail = '';
				$empPosition = '';
				$empSchool = '';
			}

			if ($success) {
				SuccessLogo('50%', '50%');
			?>
				<div class="text-center">Your account has been successfully registered. For now, please wait for the system administrator to approve your registration. Once approved, you will be notified to <a href="<?php echo GetSiteURL(); ?>/personnel/login">login</a> using your DepEd email address and password.</div>
			<?php } else {
				include_once('register-form.php');
			} ?>
		</div><!-- .card-body -->

		<div class="card-footer text-center small">
			<a href="<?php echo GetSiteURL(); ?>/login">Have an existing account? Go to login</a>
		</div><!-- .card-footer -->
	</div><!-- .card -->
</div><!-- .col-lg-6 -->