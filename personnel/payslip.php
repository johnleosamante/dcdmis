<?php
# personnel/payslip.php

if (!is_dir('../uploads/payslip/' . $_SESSION['EmpID'])) {
	mkdir('../uploads/payslip/' . $_SESSION['EmpID'], 0777, true);
}
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h3 class="h4 mb-0">Payslip</h3>
					<a href="#uploadPayslipModal" data-toggle="modal" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-upload fa-fw"></i></span><span class="text">Upload</span></a>
				</div>
			</div><!-- .card-header -->

			<div class="card-body">
				<?php
				if (isset($_POST["upload"])) {
					$status = GetImageFileUploadStatus("uploadPayslip", '../uploads/payslip/' . $_SESSION['EmpID'] . '/' . $_SESSION['EmpID'] . date("ymdHis"));

					if ($status["status"] === 0) {
						AlertBox("Sorry, file was not uploaded. " . $status["message"], 'danger', 'left');
						// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($status["temp_name"], $status["target"])) {
							mysqli_query($con, "INSERT INTO tbl_payslip_archive(Payslip_details, date_time_upload, `location`, Emp_ID) VALUES('" . $_POST['payslipinfo'] . "','" . GetDateTime() . "','" . $status["target"] . "','" . $_SESSION['EmpID'] . "')");

							if (mysqli_affected_rows($con) === 1) {
								AlertBox('Payslip has been uploaded successfully!', 'success', 'left');
							}
						} else {
							AlertBox('Sorry, there was an error uploading your file.', 'danger', 'left');
						}
					}
				}
				?>

				<div class="table-responsive">
					<table id="dataTable" class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
						<thead>
							<tr class="text-center">
								<th class="align-middle" width="10%">#</th>
								<th class="align-middle" width="20%">Date</th>
								<th class="align-middle" width="60%">Description</th>
								<th class="align-middle" width="10%">Action</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$no = 0;
							$result = mysqli_query($con, "SELECT * FROM tbl_payslip_archive WHERE Emp_ID='" . $_SESSION['EmpID'] . "' ORDER BY Payslip_details DESC;");

							while ($row = mysqli_fetch_array($result)) {
								$no++;
							?>
								<tr>
									<td class="text-center"><?php echo $no; ?></td>
									<td class="text-center"><?php echo $row['date_time_upload']; ?></td>
									<td><?php echo $row['Payslip_details']; ?></td>
									<td><a href="<?php echo $row['location']; ?>" class="btn btn-success btn-block" title="View" target="_blank"><i class="fas fa-eye fa-fw"></i> View</a></td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div><!-- .table-responsive -->
			</div><!-- .card-body -->
		</div><!-- .card -->
	</div><!-- .col -->
</div><!-- .row -->

<div class="modal fade" id="uploadPayslipModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload Payslip</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<form action="" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<textarea class="form-control" name="payslipinfo" placeholder="Description" rows="3" required></textarea>

					<div class="input-group my-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Upload</span>
						</div>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="uploadPayslip" id="fileUpload">
							<label id="fileUploadLabel" class="custom-file-label" for="fileUpload">Choose file</label>
						</div>
					</div>

					<script>
						document.getElementById('fileUpload').addEventListener('change', (event) => {
							var preview = document.getElementById('uploadPreview');
							const file = event.target.files[0];
							const name = file.name;
							const lastDot = name.lastIndexOf('.');
							const ext = name.substring(lastDot + 1);
							var label = document.getElementById('fileUploadLabel');
							label.innerText = name;

							switch (ext) {
								case 'jpg':
								case 'jpeg':
								case 'png':
								case 'gif':
									preview.src = URL.createObjectURL(event.target.files[0]);
									break;
								default:
									preview.src = '<?php echo GetSiteURL(); ?>/assets/img/nopreview.png';
									break;
							}
						});
					</script>

					<img src="../assets/img/upload.jpg" id="uploadPreview" width="100%">
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<input type="submit" name="upload" value="Upload" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>