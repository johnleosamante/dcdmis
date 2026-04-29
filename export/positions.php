<?php
// exports/positions.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/position.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Position</th>
            <th>Salary Grade</th>
            <th>Category</th>
            <th>Plantilla Items</th>
            <th>Filled</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = positionItems();
        foreach ($query as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row['official_title'] ?></td>
                <td><?= $row['salary_grade'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['total_plantilla_items'] ?></td>
                <td><?= $row['filled_plantilla_items'] ?>
                </td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="6"><?= 'Data as of ' . date("F j, Y, g:i a") ?>
            </td>
        </tr>
    </tbody>
</table>