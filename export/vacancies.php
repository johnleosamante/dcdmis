<?php
// export/vacancies.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once '../includes/function.php';
    redirect(uri() . '/login');
}

require_once root() . '/includes/database/account.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/database/school.php';
require_once root() . '/includes/database/vacancies.php';
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Position</th>
            <th>Item Number</th>
            <th>Station</th>
            <th>Remarks</th>
            <th>Date Posted</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $rowCount = 0;
        $query = vacancies();
        while ($row = fetchArray($query)): ?>
            <tr>
                <td><?= ++$rowCount ?></td>
                <td><?= $row['position'] ?></td>
                <td><?= toHandleNull($row['psipop'], 'N/A') ?></td>
                <td>
                    <?php if (empty($row['station_id'])) {
                        echo 'TO BE DETERMINED';
                    } else {
                        echo fetchAssoc(schoolById($row['station_id']))['name'];
                    } ?>
                </td>
                <td>
                    <?php if (!empty($row['employee_id'])): ?>
                        <?php $vice = fetchAssoc(employee($row['employee_id'])); ?>
                        VICE:
                        <?= toName($vice['lname'], $vice['fname'], $vice['mname'], $vice['ext'], true); ?>
                    <?php endif; ?>

                    <?= strtoupper($row['reason']) ?>
                </td>
                <td>

                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>