<?php
// export/employee-positions.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
	require_once('../includes/function.php');
	redirect(uri() . '/login');
}

require_once(root() . '/includes/database/employee.php');
?>

<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Position</th>
			<th>Male</th>
			<th>Female</th>
			<th>Total</th>
		</tr>
	</thead>

	<tbody>
		<?php
		$i = 1;
		$rows = employeePositions();

		foreach ($rows as $row): ?>
			<tr>
				<td><?= $i++ ?></td>
				<td><?= e($row['official_title']) ?></td>
				<td><?= e($row['male']) ?></td>
				<td><?= e($row['female']) ?></td>
				<td><?= e($row['total']) ?></td>
			</tr>
		<?php endforeach ?>
		<tr>
			<td colspan="5"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
		</tr>
	</tbody>
</table>