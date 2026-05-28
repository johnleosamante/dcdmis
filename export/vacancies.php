<?php
// export/vacancies.php
if (!isset($_GET['v']) || empty($_GET['v'])) {
    require_once '../includes/function.php';
    redirect(uri() . '/login');
}

require_once root() . '/includes/database/account.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/database/school.php';
require_once root() . '/includes/database/vacancy.php';
require_once root() . '/includes/database/employee.php';
?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Position</th>
            <th>Item Number</th>
            <th>Station</th>
            <th>Remarks</th>
            <th>Date Vacated</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $rowCount = 0;
        $query = vacancies();
        foreach ($query as $row): ?>
            <tr>
                <td><?= ++$rowCount ?></td>
                <td><?= e($row['official_title']) ?></td>
                <td><?= toHandleNull($row['item_number'], 'N/A') ?></td>
                <td><?= schoolById($row['station_id'])['name']; ?></td>
                <td>
                    <?php if (!empty($row['vacated_by_id'])): ?>
                        <?php $vice = employee($row['vacated_by_id']); ?>
                        VICE:
                        <?= strtoupper(toName($vice['last_name'], $vice['first_name'], $vice['middle_name'], $vice['name_extension'], true)); ?>
                    <?php endif; ?>

                    <?= strtoupper($row['reason']) ?>
                </td>
                <td>
                    <?= $row['date_vacated'] ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>