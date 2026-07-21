<?php
// modules/service-record/page.php
if (!$isPis && !$isHrmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$employeeId = (int) sanitize(decode($_GET['id'] ?? null));

$isHeadOfThisEmployee = false;
$schoolInfo = schoolByHead($userId);
if ($schoolInfo && $employeeId > 0) {
    $empStation = station($employeeId);
    if ($empStation && $empStation['station_id'] === $schoolInfo['id']) {
        $isHeadOfThisEmployee = true;
    }
}

$userPositionId = null;
if ($isPis) {
    if (!function_exists('position')) {
        require_once(root() . '/includes/database/position.php');
    }
    $userPosition = position($userId);
    $userPositionId = $userPosition['position_id'] ?? null;
}
$isAllowedHigherPosition = $isPis && (in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT);

if ($isPis && $userId !== $employeeId && !$isHeadOfThisEmployee && !$isAllowedHigherPosition) {
    require_once(root() . '/modules/error/no-results-found.php');
    return;
}

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
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Service Record</li>
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
        <?php if ($isHrmis) {
            contentTitleWithModal('Service Record : ' . strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])), uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus');
        } else {
            contentTitleWithLink('Service Record : ' . strtoupper(toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'])), uri() . '/pis');
        } ?>
    </div>

    <div class="card-body">
        <?php if ($isHrmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse my-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('print', 'Service Record', $employeeId), 'Print', 'fa-print', 'Print file', 'success', true) ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="10%">Designation</th>
                        <th class="align-middle" width="10%">Employment Status</th>
                        <th class="align-middle" width="10%">Annual Salary</th>
                        <th class="align-middle" width="15%">Office Entity/Division<br>Station/Place/Branch of
                            Assignment</th>
                        <th class="align-middle" width="10%">Leave Without Pay</th>
                        <th class="align-middle" width="5%">Separation Date</th>
                        <th class="align-middle" width="5%">Separation Cause</th>
                        <th class="align-middle" width="5%">Remarks</th>
                        <?php if ($isHrmis): ?>
                            <th class="align-middle" width="5%">Actions</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $services = experiences($employeeId);

                    foreach ($services as $service): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= toDate($service['from_date']) ?></td>
                            <td class="align-middle"><?= $service['is_present'] ? 'PRESENT' : toDate($service['to_date']) ?>
                            </td>
                            <td class="align-middle"><?= toHandleNull($service['designation'], 'N/A') ?></td>
                            <td class="align-middle"><?= e($service['appointment_status']) ?></td>
                            <td class="align-middle">
                                <?= !empty($service['monthly_salary']) ? toCurrency($service['monthly_salary'] * 12) : 'N/A' ?>
                            </td>
                            <td class="align-middle"><?= toHandleNull($service['agency_company'], 'N/A') ?></td>
                            <td class="align-middle"><?= toHandleNull($service['leave_wo_pay'], 'N/A') ?></td>
                            <td class="align-middle">
                                <?= $service['for_separation'] === '1' ? toDate($service['separation_date']) : 'N/A' ?>
                            </td>
                            <td class="align-middle">
                                <?= $service['for_separation'] === '1' ? toHandleNull($service['separation_cause'], 'N/A') : 'N/A' ?>
                            </td>
                            <td class="align-middle">
                                <?= e($service['salary_grade_step_increment']) ?>
                            </td>
                            <?php if ($isHrmis): ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($service['id']), 'Edit', 'fa-edit', 'Edit Service Record');
                                            modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($service['id']), 'Copy', 'fa-copy', 'Copy Service Record') ?>
                                            <div class="dropdown-divider"></div>
                                            <?php modalDropdownItem(uri() . '/modules/service-record/delete-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($service['id']), 'Delete', 'fa-trash', 'Delete Service Record') ?>
                                        </div>
                                    </div>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="10%">Designation</th>
                        <th class="align-middle" width="10%">Employment Status</th>
                        <th class="align-middle" width="10%">Annual Salary</th>
                        <th class="align-middle" width="15%">Office Entity/Division<br>Station/Place/Branch of
                            Assignment</th>
                        <th class="align-middle" width="10%">Leave Without Pay</th>
                        <th class="align-middle" width="5%">Separation Date</th>
                        <th class="align-middle" width="5%">Separation Cause</th>
                        <th class="align-middle" width="5%">Remarks</th>
                        <?php if ($isHrmis): ?>
                            <th class="align-middle" width="5%">Actions</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>