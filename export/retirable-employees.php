<?php
// export/retirable-employees.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
	require_once('../includes/function.php');
	redirect(uri() . '/login');
}
?>

<table>
	<thead>
		<tr>
			<th>#</th>
			<th>School/Office</th>
			<th>Employee ID</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Ext Name</th>
			<th>Sex</th>
			<th>Date of Birth</th>
			<th>Age</th>
			<th>Position</th>
			<th>GSIS CRN No.</th>
			<th>GSIS BP No.</th>
			<th>PAGIBIG ID No.</th>
			<th>PhilHealth ID No.</th>
			<th>SSS No.</th>
			<th>TIN No.</th>
			<th>Contact No.</th>
			<th>Email Address</th>
			<th>Residential Address</th>
		</tr>
	</thead>

	<tbody>
		<?php
		$i = 1;
		$rows = query("SELECT * FROM (SELECT p.`agency_id`, p.`last_name`, p.`first_name`, p.`middle_name`, p.`name_extension`, p.`sex`, p.`birth_month`, p.`birth_day`, p.`birth_year`, YEAR(CURRENT_DATE) - CONVERT(p.`birth_year`, DECIMAL) AS year_age, p.`gsis_crn`, p.`gsis_bp`, p.`pagibig`, p.`philhealth`, p.`sss`, p.`tin`, p.`mobile_number`, p.`email_address`, pos.`official_title`, s.`name` AS school, p.`residence_street`, p.`residence_subdivision`, p.`residence_barangay`, p.`residence_city`, p.`residence_province` FROM `persons` AS p INNER JOIN `station_assignments` AS sa ON p.`id`=sa.`person_id` INNER JOIN `schools` AS s ON sa.`station_id`=s.`id` INNER JOIN `positions` AS pos ON sa.`position_id`=pos.`id` WHERE p.`status`='Active') AS retirables WHERE year_age >= 60 ORDER BY school, last_name;");
		foreach ($rows as $row): ?>
			<tr>
				<td><?= $i++ ?></td>
				<td><?= strtoupper($row['school']) ?></td>
				<td><?= e($row['agency_id']) ?></td>
				<td><?= strtoupper($row['last_name']) ?></td>
				<td><?= strtoupper($row['first_name']) ?></td>
				<td><?= strtoupper($row['middle_name']) ?></td>
				<td><?= strtoupper($row['name_extension']) ?></td>
				<td><?= strtoupper($row['sex'])[0] ?></td>
				<td><?= $row['birth_year'] . '-' . $row['birth_month'] . '-' . $row['birth_day'] ?></td>
				<td><?= getDateDifference($row['birth_year'], $row['birth_month'], $row['birth_day']) ?></td>
				</td>
				<td><?= strtoupper($row['official_title']) ?></td>
				<td><?= e($row['gsis_crn']) ?></td>
				<td><?= e($row['gsis_bp']) ?></td>
				<td><?= e($row['pagibig']) ?></td>
				<td><?= e($row['philhealth']) ?></td>
				<td><?= e($row['sss']) ?></td>
				<td><?= e($row['tin']) ?></td>
				<td><?= e($row['mobile_number']) ?></td>
				<td><?= strtolower($row['email_address']) ?></td>
				<td><?= strtoupper(toAddress('', $row['residence_street'], $row['residence_subdivision'], $row['residence_barangay'], $row['residence_city'], $row['residence_province'])) ?>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>