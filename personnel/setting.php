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
					DBNonQuery("UPDATE tbl_station SET Emp_Position='" . $_POST['position'] . "' WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1;");

					if (DBAffectedRows($con) === 1) {
						AlertBox('Position has been updated successfully!', 'success', 'left');
					}
				}

				if (isset($_POST['UpdateTIN'])) {
					DBNonQuery("UPDATE tbl_employee SET Emp_TIN='" . $_POST['myTIN'] . "' WHERE Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1;");

					if (DBAffectedRows($con) === 1) {
						AlertBox('Tax Identification Number (TIN) has been updated successfully!', 'success', 'left');
					}
				}

				if (isset($_POST['UpdatePassword'])) {
					if ($_POST['password'] <> $_POST['confirm']) {
						AlertBox('Password do not match! Try again.', 'danger', 'left');
					} else {
						$pass = GetHashPassword(DBRealEscapeString($_POST['password']));

						DBNonQuery("UPDATE tbl_teacher_account SET Teacher_Password='$pass' WHERE tbl_teacher_account.Teacher_TIN='" . $_SESSION[GetSiteAlias() . '_Email'] . "' LIMIT 1;");

						$rec = DBQuery("SELECT * FROM tbl_user WHERE usercode='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");

						if (DBNumRows($rec) === 1) {
							DBNonQuery("UPDATE tbl_user SET password='$pass' WHERE usercode='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'");
						}

						AlertBox('Password has been updated successfully!', 'success', 'left');
					}
				}
				?>

				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active text-secondary" href="#user-information" data-toggle="tab">User Information</a>
					</li>

					<li class="nav-item">
						<a class="nav-link text-secondary" href="#security-login" data-toggle="tab">Security and Login</a>
					</li>
				</ul><!-- .nav-tabs -->

				<div class="tab-content pt-2 px-2">
					<div class="table-responsive tab-pane fade show active" id="user-information">
						<table>
							<?php
							$myname = DBQuery("SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =  tbl_station.Emp_ID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID WHERE tbl_employee.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "' LIMIT 1");

							$row_record = DBFetchAssoc($myname);

							$empPosition = $row_record['Job_code'];
							?>

							<tr class="border-bottom">
								<th class="py-2">Full Name:</th>
								<td class="py-2 px-3"><?php echo ToName($row_record['Emp_LName'], $row_record['Emp_FName'], $row_record['Emp_MName'], $row_record['Emp_Extension'], false, true); ?></td>
							</tr>

							<tr class="border-bottom">
								<th class="py-2">Position:</th>
								<td class="py-2 px-3"><?php echo $row_record['Job_description']; ?></td>
								<td class="py-2 px-3"><span class="small"><a class="text-decoration-none" href="#positionModal" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a></span></td>
							</tr>

							<tr class="border-bottom">
								<th class="py-2">Station:</th>
								<td class="py-2 px-3"><?php echo $row_record['SchoolName']; ?></td>
							</tr>

							<tr class="border-bottom">
								<th class="py-2">Address:</th>
								<td class="py-2 px-3"><?php echo $row_record['Emp_Address']; ?></td>
							</tr>

							<tr class="border-bottom">
								<th class="py-2">Contact Number:</th>
								<td class="py-2 px-3"><?php echo $row_record['Emp_Cell_No']; ?></td>
							</tr>

							<tr class="border-bottom">
								<th class="py-2"> Email Address: </th>
								<td class="py-2 px-3"><?php echo $row_record['Emp_Email']; ?></td>
							</tr>

							<tr>
								<th class="py-2"> TIN: </th>
								<td class="py-2 px-3"><?php echo $row_record['Emp_TIN']; ?></td>
								<td class="py-2 px-3"><span class="small"><a class="text-decoration-none" href="#TINModal" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a></span></td>
							</tr>
						</table>

						<div class="modal fade" id="positionModal" role="dialog" data-backdrop="static" data-keyboard="false">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Edit Position</h5>
										<button class="close" type="button" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>

									<form action="" Method="POST" ENCTYPE="multipart/form-data">
										<div class="modal-body">
											<select name="position" class="form-control" required>
												<option value="">Position</option>
												<?php
												$data = DBQuery("SELECT * FROM tbl_job ORDER BY Job_description;");
												while ($row = DBFetchArray($data)) { ?>
													<option value="<?php echo $row['Job_code']; ?>" <?php echo SetOptionSelected($row['Job_code'], $empPosition); ?>><?php echo $row['Job_description']; ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
											<input type="submit" class="btn btn-primary" name="UpdatePosition" value="Update">
										</div>
									</form>
								</div>
							</div>
						</div><!-- #positionModal -->

						<div class="modal fade" id="TINModal" role="dialog" data-backdrop="static" data-keyboard="false">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Edit Position</h5>
										<button class="close" type="button" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
									</div>

									<form action="" Method="POST" ENCTYPE="multipart/form-data">
										<div class="modal-body">
											<input type="text" name="myTIN" placeholder="TIN" value="<?php echo $row_record['Emp_TIN']; ?>" class="form-control">
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
											<input type="submit" class="btn btn-primary" name="UpdateTIN" value="Update">
										</div>
									</form>
								</div>
							</div>
						</div><!-- #TINModal -->
					</div><!-- .tab-pane -->

					<div class="tab-pane fade" id="security-login">
						<form class="py-2" action="" Method="POST" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
									<div class="form-group">
										<label for="inputEmail" class="mb-0">DepEd Email Address:</label>
										<input id="inputEmail" type="email" value="<?php echo $row_record['Emp_Email']; ?>" class="form-control" disabled>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
									<div class="form-group">
										<label for="inputPassword" class="mb-0">New Password:</label>
										<input type="password" id="inputPassword" name="password" class="form-control" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
									<div class="form-group">
										<label for="inputRetypePassword" class="mb-0">Retype New Password:</label>
										<input type="password" id="inputRetypePassword" name="confirm" class="form-control" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
									<div class="form-group form-check small">
										<input class="form-check-input" id="inputShowPassword" type="checkbox">
										<label class="form-check-label" for="inputShowPassword">Show password</label>
									</div><!-- .form-group -->
								</div><!-- .col-md-4 -->
							</div><!-- .row -->

							<?php ShowPassword('inputShowPassword', 'inputPassword', 'inputRetypePassword'); ?>

							<div class="row">
								<div class="col-sm-12 col-md-10 col-lg-6 col-xl-4 col">
									<input type="submit" name="UpdatePassword" value="Change" class="btn btn-primary btn-block btn-lg">
								</div>
							</div><!-- .col-sm-12 -->
						</form>
					</div><!-- .tab-content -->
				</div><!-- .card-body -->
			</div><!-- .card -->
		</div><!-- .col -->
	</div><!-- .row -->
</div>