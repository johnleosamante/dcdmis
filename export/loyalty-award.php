<?php
// export/users.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once('../includes/function.php');
    redirect(uri() . '/login');
}

require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Position</th>
            <th>Station</th>
            <th>Date of Original Appointment</th>
            <th>Years in Service</th>
            <th>Date Last Awarded</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        $query = employeeLoyaltyAward();

        foreach ($query as $row):
            $employeeName = toName($row['last_name'], $row['first_name'], $row['middle_name'], $row['name_extension']);
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= strtoupper($employeeName) ?></td>
                <td><?= strtoupper(positions($row['position_id'])['official_title']) ?></td>
                <td><?= strtoupper(schoolById($row['station_id'])['name']) ?></td>
                <td><?= toDate($row['original_appointment_date'], 'F j, Y') ?></td>
                <td><?= e($row['total_years_service']) ?></td>
                <td><?= toDate($row['date_last_awarded'], 'F j, Y') ?></td>
            </tr>
        <?php endforeach ?>

        <tr>
            <td colspan="7"><?= 'Data as of ' . date("F j, Y, g:i a") ?></td>
        </tr>
    </tbody>
</table>