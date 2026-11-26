<?php
// export/users.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/account.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Station</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $rows = users();
        $rows = is_array($rows) ? $rows : [];

        foreach ($rows as $row):
            $employeeName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension']);
            $pos = !empty($row['position_id']) ? positions($row['position_id']) : null;
            $school = !empty($row['station_id']) ? schoolById($row['station_id']) : null;
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= e(strtoupper($employeeName)) ?></td>
                <td><?= e(strtolower($row['email_address'] ?? '')) ?></td>
                <td><?= e(strtoupper($pos['official_title'] ?? 'N/A')) ?></td>
                <td><?= e(strtoupper($school['name'] ?? 'N/A')) ?></td>
                <td><?= e(strtoupper($row['status'] ?? '')) ?></td>
            </tr>
        <?php endforeach ?>

        <tr>
            <td colspan="6"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>