<?php
// modules/activity/edit-history.php
$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : $userId;
$employees = employee($employeeId);

if (numRows($employees) > 0) {
    $employee = fetchAssoc($employees);
    $employeeId = $employee['id'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

if ($isHrmis) {
    require_once(root() . '/modules/employees/employee-tabs.php');
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Edit History : ' . strtoupper(toName($employee['lname'], $employee['fname'], $employee['mname'], $employee['ext']))); ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-hovered mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Date/Time</th>
                        <th class="align-middle" width="50%">Activity</th>
                        <th class="align-middle" width="25%">Editor</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = employeeEditHistory($employeeId);
                    $no = 0;
                    while ($row = fetchAssoc($query)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?php echo ++$no; ?></td>
                            <td class="align-middle"><?php echo toDateTime($row['datetime']); ?></td>
                            <td class="text-left align-middle"><?php echo $row['activity']; ?></td>
                            <td class="text-center align-middle">
                                <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['editor']), userName($row['editor']));

                                if ($isDmis || $isHrmis) : ?>
                                    <br><small><?php echo '(' . $row['ip'] . ')'; ?></small>
                                <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Date/Time</th>
                        <th class="align-middle" width="50%">Activity</th>
                        <th class="align-middle" width="25%">Editor</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>