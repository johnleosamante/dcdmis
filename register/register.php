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
				$employeeID = date('YmdHis');
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

				if ($_POST['password'] === $_POST['repass']) {
					$record = DBQuery("SELECT * FROM tbl_employee WHERE Emp_LName='$empLName' AND Emp_FName='$empFName' AND Emp_MName='$empMName' AND Emp_Extension='$empExt' LIMIT 1;");

					if (DBNumRows($record) === 0) {
						DBNonQuery("INSERT into tbl_employee values ('$employeeID', '$empLName', '$empFName', '$empMName', '$empExt', '$empBMonth', '$empBDay', '$empBYear', '', '$empSex', '', '', '', '', '', '', '$empContact', '$empEmail', '$empImage', '', 'Registered', '-', '', '');");
						DBNonQuery("INSERT into tbl_station values(NULL, '-', '$empPosition', '$empSchool', '-', '-', '$age', '$employeeID');");
						DBNonQuery("INSERT INTO tbl_deployment_history VALUES(NULL, '-', '$empSchool', '$empPosition', '0', '$employeeID', '', '');");
						DBNonQuery("INSERT INTO tbl_step_increment VALUES(NULL, '$start', '1', '0', '$employeeID');");
					}

					$user = DBQuery("SELECT * FROM tbl_teacher_account WHERE Teacher_TIN='$empEmail' LIMIT 1;");
					$pass = GetHashPassword($_POST['password']);

					if (DBNumRows($user) == 1) {
						DBNonQuery("UPDATE tbl_teacher_account SET Teacher_Password='$pass' WHERE Teacher_TIN='$empEmail' LIMIT 1;");
					} else {
						DBNonQuery("INSERT INTO tbl_teacher_account VALUES(NULL, '$empEmail', '$pass', 'Offline', 'Default', '$dateposted');");
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