<?php
# personnel/certificate.php

if (!is_dir('../uploads/certificate/' . $_SESSION['EmpID'])) {
	mkdir('../uploads/certificate/' . $_SESSION['EmpID'], 0777, true);
}
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<div class="d-sm-flex align-items-center justify-content-between">
					<h3 class="h4 mb-0"><?php echo $_GET['id']; ?> Certificates</h3>
					<a href="#uploadCertificateModal" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal"><span class="icon text-white-50"><i class="fa fa-upload fa-fw"></i></span><span class="text">Upload</span></a>
				</div>
			</div>

			<div class="card-body">
				<?php
				if (isset($_POST["upload"])) {
					$file = $_FILES["uploadCertificate"]["name"];
					$temp = $_FILES["uploadCertificate"]["tmp_name"];
					$ext = pathinfo($file, PATHINFO_EXTENSION);
					$target_dir = '../uploads/certificate/' . $_SESSION['EmpID'];
					$target_file = $target_dir . '/' . $_SESSION['EmpID'] . date("YmdHis") . '.' . $ext;;
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
					$message = '';

					// Check if file already exists
					if (file_exists($target_file)) {
						$message = "File already exists.";
						$uploadOk = 0;
					}

					// Check file size
					if ($_FILES["uploadCertificate"]["size"] > 5000000) {
						$message = "The selected file is too large.";
						$uploadOk = 0;
					}

					// Allow certain file formats
					if (
						$ext != "jpg" && $ext != "png" && $ext != "jpeg"
						&& $ext != "gif"
					) {
						$message = "Only JPG, JPEG, PNG & GIF file formats are allowed.";
						$uploadOk = 0;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk === 0) {
						AlertBox("Sorry, file was not uploaded. $message", 'danger', 'left');
						// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($temp, $target_file)) {
							mysqli_query($con, "INSERT INTO tbl_certificate_archive VALUES(NULL,'" . $_POST['cert_details'] . "','" . $_POST['category'] . "','" . GetDateTime() . "','" . $_GET['id'] . "', '$target_file','" . $_SESSION['EmpID'] . "')");

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
					<table width="100%" class="table table-striped table-bordered table-hover" cellspacing="0" id="dataTable">
						<thead>
							<tr class="text-center align-middle">
								<th>#</th>
								<th>Descriptions</th>
								<th>Category</th>
								<th class="text-center align-middle" width="100px">Action</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$no = 0;
							$result = mysqli_query($con, "SELECT * FROM tbl_certificate_archive WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND Certificate_Level='" . $_GET['id'] . "'");

							while ($row = mysqli_fetch_array($result)) {
								$no++;
							?>
								<tr>
									<td class="text-center"><?php echo $no; ?></td>
									<td><?php echo $row['Certificate_details']; ?></td>
									<td class="text-center"><?php echo $row['Certificate_category']; ?></td>
									<td><a href="<?php echo $row['location']; ?>" class="text-xs btn btn-success btn-block" title="Download" target="_blank"><i class="fas fa-download fa-fw"></i> Download</a></td>
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

<div class="modal fade" id="uploadCertificateModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload Certificate</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<form action="" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<textarea rows="3" class="form-control" name="cert_details" placeholder="Description" required></textarea>

					<select name="category" class="form-control my-3" required>
						<option value="">Category</option>
						<option value="Participation">Participation</option>
						<option value="Recognition">Recognition</option>
						<option value="Merit">Merit</option>
					</select>

					<div class="input-group my-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Upload</span>
						</div>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="uploadCertificate" id="fileUpload">
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

					<img src="../assets/img/upload.jpg" id="uploadPreview" style="width:100%">
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<input type="submit" name="upload" value="Upload" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>