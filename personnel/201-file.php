<?php
if (!is_dir('../uploads/201_files/' . $_SESSION['EmpID'])) {
	mkdir('../uploads/201_files/' . $_SESSION['EmpID'], 0777, true);
}

$_SESSION['pathlocation'] = 'uploads/201_files/' . $_SESSION['EmpID'];
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<h3 class="h4 mb-0">201 Files</h3>
			</div>

			<div class="card-body">
				<?php
				$emp_info = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID = tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station=tbl_school.SchoolID WHERE tbl_employee.Emp_ID='" . $_SESSION['EmpID'] . "'") or die("Error information data");
				$data = mysqli_fetch_assoc($emp_info);

				$_SESSION['surname'] = $data['Emp_LName'];
				$_SESSION['given'] = $data['Emp_FName'];
				$_SESSION['middle'] = mb_strimwidth($data['Emp_MName'], 0, 1);
				$_SESSION['birth'] = $data['Emp_Month'] . '/' . $data['Emp_Day'] . '/' . $data['Emp_Year'];
				$_SESSION['place'] = $data['Emp_place_of_birth'];
				?>

				<div class="row">
					<div class="col-lg-2 col-md-5 col-sm-12 col-xs-12">
						<img src="../<?php echo $data['Picture']; ?>" width="100%">
					</div>

					<div class="col-lg-10 col-md-7 col-sm-12 col-xs-12">
						<table>
							<tr class="border-bottom">
								<th class="px-2 py-3">Last Name:</th>
								<td class="px-2 py-3"><?php echo $data['Emp_LName']; ?></td>
							</tr>
							<tr class="border-bottom">
								<th class="px-2 py-3">First Name:</th>
								<td class="px-2 py-3"><?php echo $data['Emp_FName']; ?></td>
							</tr>
							<tr class="border-bottom">
								<th class="px-2 py-3">Middle Name:</th>
								<td class="px-2 py-3"><?php echo $data['Emp_MName']; ?></td>
							</tr>
							<tr>
								<th class="px-2 py-3">Name Extension:</th>
								<td class="px-2 py-3"><?php echo $data['Emp_Extension']; ?></td>
							</tr>
						</table>
					</div>
				</div>

				<div class="row mt-4">
					<div class="col table-responsive">
						<table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0">
							<thead>
								<tr class="text-center">
									<th class="align-middle" width="10%">#</th>
									<th class="align-middle" width="80%">Filename</th>
									<th class="align-middle" width="10%">Action</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$dir = '../' . $_SESSION['pathlocation'];
								$no = 0;

								if ($dir_list = opendir($dir)) {
									while (($filename = readdir($dir_list)) !== false) {
										if (!is_dir($filename)) {
											$no++;
								?>
											<tr>
												<td class="text-center align-middle"><?php echo $no; ?></td>
												<td class="align-middle"><?php echo $filename; ?></td>
												<td class="text-center align-middle"><a class="btn btn-success my-1" href="<?php echo $dir . '/' . $filename; ?>" target="_blank"><i class="fas fa-eye fa-fw"></i></a></td>
											</tr>
									<?php
										}
									}

									closedir($dir_list);
								}

								if ($no === 0) { ?>
									<tr>
										<td class="text-center align-middle" colspan="3">No available files to show.</td>
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