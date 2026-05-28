<?php
// exports/plantilla-items.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/plantilla.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Item Number</th>
            <th>Position Title</th>
            <th>Salary Grade</th>
            <th>Category</th>
            <th>Employment</th>
            <th>Station</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = plantillaItems();
        foreach ($query as $row) {
            $vacantText = $row['is_vacant'] ? 'Vacant' : 'Filled'; ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row['item_number'] ?></td>
                <td><?= $row['official_title'] ?></td>
                <td><?= $row['salary_grade'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['employment_status'] ?></td>
                <td><?= $row['station_name'] ?></td>
                <td><?= $vacantText ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="8"><?= 'Data as of ' . date("F j, Y, g:i a") ?>
            </td>
        </tr>
    </tbody>
</table>