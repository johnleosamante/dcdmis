<?php
// modules/transfer-request/hrmis-page.php
if (!$isHrmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Transfer Requests</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Transfer Requests'); ?>
    </div>

    <div class="card-body pb-0">
        <ul class="nav nav-tabs mb-4" id="transferRequestsTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active text-secondary" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                    aria-controls="pending" aria-selected="true">
                    Pending Requests
                    <?php
                    $allRequests = getAllTransferRequests();
                    $pendingCount = 0;
                    foreach ($allRequests as $r) {
                        if ($r['status'] === 'Pending') {
                            $pendingCount++;
                        }
                    }
                    if ($pendingCount > 0): ?>
                        <span class="badge badge-secondary ml-1">
                            <?= $pendingCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-secondary" id="processed-tab" data-toggle="tab" href="#processed" role="tab"
                    aria-controls="processed" aria-selected="false">
                    Processed History
                </a>
            </li>
        </ul>

        <div class="tab-content" id="transferRequestsTabsContent">
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="row my-3">
                    <div class="col table-responsive">
                        <table class="table table-hover mb-0 text-center" id="data-table-next" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th class="align-middle" width="30%">Employee</th>
                                    <th class="align-middle" width="15%">Requested on</th>
                                    <th class="align-middle" width="50%">Transfer Details</th>
                                    <th class="align-middle" width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $hasPending = false;
                                foreach ($allRequests as $row):
                                    if ($row['status'] !== 'Pending')
                                        continue;
                                    $hasPending = true;
                                    $employeeName = userName($row['employee_id'], true);
                                    $employee = employee($row['employee_id']);
                                    $photo = file_exists(root() . '/' . $employee['profile_picture']) ? uri() . '/' . $employee['profile_picture'] : uri() . '/assets/img/user.png';
                                    ?>
                                    <tr>
                                        <td class="align-middle">
                                            <div class="image-container">
                                                <span
                                                    class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                                    <img height="100%" src="<?= e($photo) ?>" alt="<?= e($employeeName) ?>">
                                                </span>
                                                <div class="sex-sign"><?php sex($employee['sex']) ?></div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-left">
                                            <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($employee['id']), $employeeName); ?>
                                            <div class="small text-uppercase">
                                                <?= position($employee['id'])['official_title'] ?>
                                            </div>
                                        </td>
                                        <td class="align-middle text-uppercase small">
                                            <?= toDateTime($row['created_at']) ?>
                                        </td>
                                        <td class="align-middle text-left small">
                                            <strong>Current Station:</strong>
                                            <?= e(stationName($row['current_station_id'])) ?><br>
                                            <strong>Preferred Station:</strong>
                                            <?= e(stationName($row['target_station_id'])) ?>
                                            <?php if (!empty($row['specialization'])): ?>
                                                <br><strong>Specialization:</strong>
                                                <?= e($row['specialization']) ?>
                                            <?php endif; ?>
                                            <?= !empty($row['reason']) ? '<br><strong>Reason:</strong> ' . e($row['reason']) : '' ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown no-arrow">
                                                <?php dropdownEllipsis() ?>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                    <?php if (!empty($row['attachment_path'])):
                                                        linkDropdownItem(uri() . '/' . e($row['attachment_path']), 'View Attachment', 'fa-eye', 'View Document Attachment', true); ?>
                                                        <div class="dropdown-divider"></div>
                                                    <?php endif; ?>
                                                    <?php modalDropdownItem(uri() . '/modules/transfer-request/approve-request-dialog.php?id=' . cipher($row['id']), 'Approve', 'fa-thumbs-up', 'Approve Transfer'); ?>
                                                    <?php modalDropdownItem(uri() . '/modules/transfer-request/disapprove-request-dialog.php?id=' . cipher($row['id']), 'Disapprove', 'fa-thumbs-down', 'Disapprove Transfer'); ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr class="small">
                                    <th width="5%"></th>
                                    <th class="align-middle" width="30%">Employee</th>
                                    <th class="align-middle" width="15%">Requested on</th>
                                    <th class="align-middle" width="50%">Transfer Details</th>
                                    <th class="align-middle" width="5%">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Processed Requests Tab -->
            <div class="tab-pane fade" id="processed" role="tabpanel" aria-labelledby="processed-tab">
                <div class="row my-3">
                    <div class="col table-responsive">
                        <table class="table table-hover mb-0 text-center" id="data-table-previous" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%"></th>
                                    <th class="align-middle" width="30%">Employee</th>
                                    <th class="align-middle" width="15%">Requested on</th>
                                    <th class="align-middle" width="40%">Transfer Details</th>
                                    <th class="align-middle" width="10%">Status</th>
                                    <th class="align-middle" width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $hasProcessed = false;
                                foreach ($allRequests as $row):
                                    if ($row['status'] === 'Pending')
                                        continue;
                                    $hasProcessed = true;
                                    $employeeName = userName($row['employee_id'], true);
                                    $statusClass = $row['status'] === 'Approved' ? 'success' : 'danger';
                                    $employee = employee($row['employee_id']);
                                    $photo = file_exists(root() . '/' . $employee['profile_picture']) ? uri() . '/' . $employee['profile_picture'] : uri() . '/assets/img/user.png';
                                    ?>
                                    <tr>
                                        <td class="align-middle">
                                            <div class="image-container">
                                                <span
                                                    class="d-flex justify-content-center align-middle employee-photo rounded-circle overflow-hidden">
                                                    <img height="100%" src="<?= e($photo) ?>" alt="<?= e($employeeName) ?>">
                                                </span>
                                                <div class="sex-sign"><?php sex($employee['sex']) ?></div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-left">
                                            <?php modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($employee['id']), $employeeName); ?>
                                            <div class="small text-uppercase">
                                                <?= position($employee['id'])['official_title'] ?>
                                            </div>
                                        </td>
                                        <td class="align-middle text-uppercase small">
                                            <?= toDateTime($row['created_at']) ?>
                                        </td>
                                        <td class="align-middle text-left small">
                                            <strong>From:</strong>
                                            <?= e(stationName($row['current_station_id'])) ?><br>
                                            <strong>To:</strong>
                                            <?= e(stationName($row['target_station_id'])) ?>
                                            <?php if (!empty($row['specialization'])): ?>
                                                <br><strong>Specialization:</strong>
                                                <?= e($row['specialization']) ?>
                                            <?php endif; ?>
                                            <?= !empty($row['reason']) ? '<br><strong>Reason:</strong> ' . e($row['reason']) : '' ?>
                                            <?= !empty($row['remarks']) ? '<br><strong>Remarks:</strong> ' . e($row['remarks']) : '' ?>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-<?= $statusClass ?> py-1 px-2 text-uppercase">
                                                <?= e($row['status']) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown no-arrow">
                                                <?php dropdownEllipsis() ?>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                    <?php if (!empty($row['attachment_path'])):
                                                        linkDropdownItem(uri() . '/' . e($row['attachment_path']), 'View Attachment', 'fa-eye', 'View Document Attachment', true); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr class="small">
                                    <th width="5%"></th>
                                    <th class="align-middle" width="30%">Employee</th>
                                    <th class="align-middle" width="15%">Requested on</th>
                                    <th class="align-middle" width="40%">Transfer Details</th>
                                    <th class="align-middle" width="10%">Status</th>
                                    <th class="align-middle" width="5%">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>