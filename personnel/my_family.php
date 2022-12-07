<div class="modal-header">
	<h5 class="modal-title">Update Family Member</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>

<form action="" Method="POST" enctype="multipart/form-data">
	<div class="modal-body">


	
		<table width="100%" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th width="20%">Family Name</th>
					<th width="30%">First Name</th>
					<th width="30%">Middle Name</th>
					<th width="10%">Birthdate</th>
					<th width="10%">Relation</th>
				</tr>
			</thead>

			<tbody>
				<?php
				include_once('../_includes_/function.php');
				include_once('../_includes_/database/database.php');
				foreach ($_GET as $key => $data) {
					$id = $_GET[$key] = base64_decode(urldecode($data));
				}
				$_SESSION['No'] = $id;
				$result1 = mysqli_query($con, "SELECT * FROM family_background WHERE Emp_ID='" . $_SESSION['EmpID'] . "' AND No ='" . $id . "'");

				while ($row1 = mysqli_fetch_array($result1)) {
					echo '<tr><td style="text-align:center;"><input type="text" name="Lname" class="form-control" value="' . $row1['Family_Name'] . '"></td>
													  <td style="text-align:center;"><input type="text" name="Fname" class="form-control" value="' . $row1['First_Name'] . '"></td>
													  <td style="text-align:center;"><input type="text" name="Mname" class="form-control" value="' . $row1['Middle_Name'] . '"></td>
													  <td style="text-align:center;"><input type="date" name="Bdate" class="form-control" value="' . $row1['Birthdate'] . '"></td>
													  <td style="text-align:center;"><input type="text" name="Relate" class="form-control" value="' . $row1['Relation'] . '"></td>
													  
												  </tr>';
				}
				?>
			</tbody>
		</table>
	</div><!-- .modal-body -->

	<div class="modal-footer">
		<input type="submit" name="update_family" value="Update" class="btn btn-primary">
	</div><!-- .modal-footer -->
</form>