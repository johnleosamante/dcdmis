<?php
# personnel/training.php
?>

<div class="row mt-3 mb-4">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<?php ContentTitle('Trainings'); ?>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTable" cellspacing="0">
						<thead>
							<th class="text-center align-middle">#</th>
							<th class="text-center align-middle">Title of Training</th>
							<th class="text-center align-middle">From</th>
							<th class="text-center align-middle">To</th>
							<th class="text-center align-middle">Venue</th>
							<th class="text-center align-middle" width="100px">Action</th>
						</thead>
						<tbody>
							<?php
							$no = 0;
							$seminar = mysqli_query($con, "SELECT * FROM tbl_seminar_participant INNER JOIN tbl_seminar ON tbl_seminar_participant.Training_Code = tbl_seminar.Training_Code WHERE tbl_seminar_participant.Emp_ID='" . $_SESSION[GetSiteAlias() . '_EmpID'] . "'") or die("error training data");

							while ($row = mysqli_fetch_array($seminar)) {
								$no++;
							?>
								<tr>
									<td class="text-center"><?php echo $no; ?></td>
									<td><?php echo $row['Title_of_training']; ?></td>
									<td><?php echo $row['covered_from']; ?></td>
									<td><?php echo $row['covered_to']; ?></td>
									<td><?php echo $row['TVenue']; ?></td>
									<td><a href="<?php echo GetHashURL('personnel', $row['Training_Code'], 'View Activity'); ?>" class="text-xs btn btn-primary btn-block" title="View"><i class="fas fa-eye fa-fw"></i> View</a></td>
								</tr>
							<?php
							}
							?>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>