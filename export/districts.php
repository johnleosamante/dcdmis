<?php
// export/districts.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/utility.php');
?>

<table>
    <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">District</th>
            <th rowspan="2">Supervisor</th>
            <th colspan="4">School Categories</th>
        </tr>
        <tr>
            <th>ES</th>
            <th>HS</th>
            <th>IS</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = districts();

        foreach ($query as $row): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= strtoupper($row['name']) ?></td>
                <td><?= userName($row['supervisor_id'], true) ?></td>
                <?php
                $count = districtSchoolCount($row['id']);
                $es = $hs = $is = $total = 0;

                if ($count) {
                    $es = $count['es'];
                    $hs = $count['hs'];
                    $is = $count['is'];
                    $total = $count['total'];
                }
                ?>
                <td><?= toHandleNull($es, '0') ?></td>
                <td><?= toHandleNull($hs, '0') ?></td>
                <td><?= toHandleNull($is, '0') ?></td>
                <td><?= e($total) ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="7"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>