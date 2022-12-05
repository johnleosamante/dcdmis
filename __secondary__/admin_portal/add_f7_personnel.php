<style>
	th,
	td {
		text-transform: uppercase;
	}
</style>

<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php
			if (isset($_POST['add'])) {
				mysqli_query($con, "INSERT INTO tbl_f7_salary VALUES (NULL,'" . $_POST['Basic'] . "','" . $_POST['PERA'] . "','" . $_POST['PName'] . "','" . $_GET['Code'] . "')");
				
				if (mysqli_affected_rows($con) == 1) {
			?>
				<script type="text/javascript">
					$(document).ready(function() {
						$('#addrecord').modal({ show: 'true' });
					});
				</script>
			<?php
				}
			}

			$mypayroll = mysqli_query($con, "SELECT * FROM tbl_salary_station WHERE CodeNo='" . $_GET['Code'] . "' LIMIT 1");
			$myrow = mysqli_fetch_assoc($mypayroll);
			?>
			
			<label>Station Code:</label>
			<label><?php echo $_GET['Code']; ?></label><br/>
			<label>Station:</label>
			<label><?php echo $myrow['Station']; ?></label><br/>
		</div>

		<!-- /.panel-heading -->
		<div class="panel-body">
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
				<thead>
					<tr>
						<th style="text-align:center;width:10%;">EmpNo</th>
						<th>Employee Name</th>
						<th width="25%">Position Title</th>
						<th width="5%"></th>
					</tr>
				</thead>

				<tbody>
				<?php
				$mypersonnel = mysqli_query($con, "SELECT * FROM tbl_employee INNER JOIN tbl_station ON tbl_employee.Emp_ID =tbl_station.Emp_ID INNER JOIN tbl_school ON tbl_station.Emp_Station = tbl_school.SchoolID INNER JOIN tbl_job ON tbl_station.Emp_Position=tbl_job.Job_code WHERE tbl_employee.Emp_Status ='Active' ORDER BY tbl_employee.Emp_LName Asc");

				while ($rowpersonnel = mysqli_fetch_array($mypersonnel)) { ?>
					<tr>
						<td><?php echo $rowpersonnel['Emp_ID']; ?></td>
						<td><?php echo $rowpersonnel['Emp_LName'] . ', ' . $rowpersonnel['Emp_FName'] . ', ' . $rowpersonnel['Emp_MName']; ?></td>
						<td><?php echo $rowpersonnel['Job_description']; ?></td>
						<td style="text-align:center;"><a href="set_salary.php?code=<?php echo urlencode(base64_encode($rowpersonnel['Emp_ID'])); ?>" data-target="#editnew" data-toggle="modal">Add</a></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div><!-- /.panel-body -->
	</div><!-- /.panel -->
</div><!-- /.col-lg-12 -->

<!-- Modal for Re-assign-->
<div class="panel-body">
	<!-- Modal -->
	<div class="modal fade" id="editnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			</div>
		</div>
	</div>
</div>

<!-- Modal for Re-assign-->
<div class="panel-body">
	<!-- Modal -->
	<div class="modal fade" id="addrecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
					<h3 class="modal-title text-center">Successfully Save!</h3>
				</div>

				<div class="modal-body">
					<img src="../pcdmis/logo/check.png" width="100%" height="30%">
						<a href="./?<?php echo $str . '7e9ff1f60111f1bf6a3696b2092ac4a7285cd942&Code=' . urlencode(base64_encode($_GET['Code'])) . '&v=' . urlencode(base64_encode("view_payroll_record")); ?>" class="btn btn-success">NEXT</a>
				</div>
			</div>
		</div>
	</div>
</div>