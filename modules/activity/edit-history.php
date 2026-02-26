<?php
// modules/activity/edit-history.php
$employeeId = isset($_GET['id']) ? sanitize(decode($_GET['id'])) : $userId;
$employee = employee($employeeId);

if ($employee) {
    $employeeId = $employee['id'];
} else {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Edit History</li>
        </ol>
    </nav>
</div>

<?php
if ($isHrmis) {
    require_once(root() . '/modules/employees/employee-tabs.php');
}
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Edit History : ' . strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension']))) ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-hovered mb-0 text-center" id="data-table" width="100%"
                cellspacing="0">
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
                    foreach ($query as $row): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= ++$no ?></td>
                            <td class="align-middle"><?= toDateTime($row['created_at']) ?></td>
                            <td class="text-left align-middle"><?= $row['action'] ?></td>
                            <td class="text-center align-middle">
                                <?php
                                $person_id = $row['person_id'];
                                modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($person_id), userName($person_id));

                                if ($isDmis || $isHrmis): ?>
                                    <br><small><?= '(' . $row['ip'] . ')' ?></small>
                                <?php endif ?>
                        </tr>
                    <?php endforeach ?>
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