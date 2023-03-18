<?php
if (!is_dir('../uploads/201_files/' . $_SESSION['EmpID'])) {
	mkdir('../uploads/201_files/' . $_SESSION['EmpID'], 0777, true);
}

$_SESSION['pathlocation'] = '../uploads/201_files/' . $_SESSION['EmpID'];
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<h3 class="h4 mb-0">201 Files</h3>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table width="100%" class="table table-striped table-bordered table-hover mb-0" cellspacing="0" id="dataTable">
						<thead>
							<tr class="text-center">
								<th class="align-middle" width="10%">#</th>
								<th class="align-middle" width="80%">Filename</th>
								<th class="align-middle" width="10%">Action</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$dir = $_SESSION['pathlocation'];
							$no = 0;

							if ($dir_list = opendir($dir)) {
								while (($filename = readdir($dir_list)) !== false) {
									if (!is_dir($filename)) {
										$no++;
							?>
										<tr>
											<td class="text-center align-middle"><?php echo $no; ?></td>
											<td class="align-middle"><?php echo $filename; ?></td>
											<td class="text-center align-middle">
												<a class="btn btn-success btn-block" href="<?php echo $dir . '/' . $filename; ?>" target="_blank"><i class="fas fa-eye fa-fw"></i> View</a>
											</td>
										</tr>
								<?php
									}
								}

								closedir($dir_list);
							}

							if ($no === 0) { ?>
								<tr>
									<td class="text-center align-middle" colspan="3">No available file to show</td>
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