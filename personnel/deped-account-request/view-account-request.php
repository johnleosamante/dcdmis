<?php
include_once('../../_includes_/function.php');
include_once('../../_includes_/database/database.php');

$_SESSION['curticket'] = $_GET['id'];
$result = mysqli_query($con, "SELECT * FROM tbl_deped_reset_account INNER JOIN tbl_deped_reset_account_logs ON tbl_deped_reset_account.TicketNo= tbl_deped_reset_account_logs.TicketNo WHERE tbl_deped_reset_account.TicketNo='" . $_GET['id'] . "' LIMIT 1");

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$email = $row['depedemail'];
	$password = $row['TempPassword'];
} else {
	$email = $password = '';
}
?>

<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">DepEd Account Request</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
		</div>

		<div class="modal-body">
			<div class="form-group">
				<label class="mb-0">Email Address:</label>
				<input type="email" value="<?php echo $email; ?>" class="form-control" disabled>
			</div>

			<div class="form-group mb-0">
				<label class="mb-0">Temporary Password:</label>
				<input type="text" name="tempPassword" value="<?php echo $password; ?>" class="form-control" required disabled>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>