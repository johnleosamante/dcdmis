<?php
# personnel/pds.php

if (!is_dir('../uploads/images/' . $_SESSION['EmpID'])) {
	mkdir('../uploads/images/' . $_SESSION['EmpID'], 0777, true);
}
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<?php
				$total = $fam = $educ = $civil = $work = $volun = $learn = $other = $ref = 0;

				$family_data = mysqli_query($con, "SELECT * FROM family_background WHERE family_background.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($family_data) <> 0) {
					$fam = 10;
				}
				$educ_data = mysqli_query($con, "SELECT * FROM educational_background WHERE educational_background.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($educ_data) <> 0) {
					$educ = 15;
				}
				$civil_data = mysqli_query($con, "SELECT * FROM civil_service WHERE civil_service.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($civil_data) <> 0) {
					$civil = 15;
				}
				$work_data = mysqli_query($con, "SELECT * FROM work_experience WHERE work_experience.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($work_data) <> 0) {
					$work = 5;
				}
				$voluntary_data = mysqli_query($con, "SELECT * FROM voluntary_work WHERE voluntary_work.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($voluntary_data) <> 0) {
					$volun = 5;
				}
				$learning_data = mysqli_query($con, "SELECT * FROM learning_and_development WHERE learning_and_development.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($learning_data) <> 0) {
					$learn = 20;
				}
				$other_data = mysqli_query($con, "SELECT * FROM other_information WHERE other_information.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($other_data) <> 0) {
					$other = 10;
				}
				$reference_data = mysqli_query($con, "SELECT * FROM reference WHERE reference.Emp_ID='" . $_SESSION['EmpID'] . "'");
				if (mysqli_num_rows($reference_data) <> 0) {
					$ref = 20;
				}
				$total = $fam + $educ + $civil + $work + $volun + $learn + $other + $ref;
				?>
				<h3 class="h4 mb-2">Personal Data Sheet<span class="float-right"><?php echo $total; ?>% Complete</span></h3>
				<div class="progress">
					<div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $total; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $total; ?>%"></div>
				</div>
			</div>

			<div class="card-body">
				<div class="row mb-4">
					<div class="col-md-2">
						<div class="card border-0">
							<img class="rounded-circle" src="<?php echo GetSiteURL() . '/' . $_SESSION['Picture']; ?>" width="100%">
						</div>
					</div>

					<div class="col-md-10">
						<div class="card">
							<div class="card-body table-responsive">
								<table>
									<tr>
										<th class="pr-3">Full Name:</th>
										<td class="pr-3"><?php echo ToName($_SESSION['Last_Name'], $_SESSION['First_Name'], $_SESSION['Middle_Name'], '', false, true); ?></td>
									</tr>

									<tr>
										<th class="pr-3">Date of Birth:</th>
										<td class="pr-3"><?php echo $_SESSION['Birthdate']; ?></td>
									</tr>

									<tr>
										<th class="pr-3">Civil Status:</th>
										<td class="pr-3"><?php echo $_SESSION['Civil_Status']; ?></td>
									</tr>

									<tr>
										<th class="pr-3">Sex:</th>
										<td class="pr-3"><?php echo $_SESSION['Gender']; ?></td>
									</tr>

									<tr>
										<th class="pr-3">Contact No.:</th>
										<td class="pr-3"><?php echo $_SESSION['Cell_No']; ?></td>
										<td><a class="small" href="#MyCell" data-toggle="modal"><i class="fas fa-edit fa-fw"></i> Edit</a></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>

				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active text-secondary" href="#personal-information" data-toggle="tab">Personal Information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#family-background" data-toggle="tab">Family Background</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#educational-background" data-toggle="tab">Educational Background</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#eligibility" data-toggle="tab">Civil Service Eligibility</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#work-experience" data-toggle="tab">Work Experience</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#voluntary-work" data-toggle="tab">Voluntary Work</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#learning-development" data-toggle="tab">Learning and Development</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#other-information" data-toggle="tab">Other Information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-secondary" href="#references" data-toggle="tab">References</a>
					</li>
				</ul>

				<div class="tab-content pt-2 px-2">
					<?php include_once('pds/personal-information.php'); ?>

					<div class="tab-pane fade" id="family-background">
						Family Background
					</div>
					<div class="tab-pane fade" id="educational-background">
						Educational Background
					</div>
					<div class="tab-pane fade" id="eligibility">
						Eligibility
					</div>
					<div class="tab-pane fade" id="work-experience">
						Work Experience
					</div>
					<div class="tab-pane fade" id="voluntary-work">
						Voluntary Work
					</div>
					<div class="tab-pane fade" id="learning-development">
						Learning and Development
					</div>
					<div class="tab-pane fade" id="other-information">
						Other Information
					</div>
					<div class="tab-pane fade" id="references">
						References
					</div>
				</div>
			</div>
		</div>
	</div>
</div>