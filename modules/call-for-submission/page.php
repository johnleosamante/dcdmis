<?php
// modules/call-for-submission/page.php

$userPositionId = null;
if ($isPis) {
    if (!function_exists('position')) {
        require_once(root() . '/includes/database/position.php');
    }
    $userPositionId = position($userId)['position_id'] ?? null;
}

$isNonDivision = $stationId !== DIVISION_ID;
if (!$isPis || $stationId === null || $isNonDivision) {
    require_once(root() . '/modules/error/403.php');
    return;
}

$cfsList = callForSubmissions();

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Call for Submissions</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if (empty($cfsList)) {
            contentTitle('Call for Submissions');
        } else {
            contentTitleWithModal('Call for Submissions', uri() . '/modules/call-for-submission/save-call-for-submission-dialog.php', 'Create', 'fa-plus');
        } ?>
    </div>
    <div class="card-body">
        <?php if (empty($cfsList)): ?>
            <div class="text-center text-muted pt-5 pb-2">
                <i class="fas fa-inbox fa-3x mb-3 text-gray-300"></i>
                <p class="lead mb-0">No call for submissions yet</p>
                <p class="small m-0">Click <strong>Create</strong> to add a new one.</p>
                <div class="text-center">
                    <?php modalButtonSplit(uri() . '/modules/call-for-submission/save-call-for-submission-dialog.php', 'Create', 'fa-plus', 'Create Call for Submission') ?>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="align-middle text-left" width="70%">Title / School Year / Description</th>
                            <th class="align-middle" width="15%">Due</th>
                            <th class="align-middle" width="10%">Submissions</th>
                            <th class="align-middle" width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cfsList as $row):
                            $subCount = countProgramSubmissions((int) $row['id']);
                            $isOverdue = strtotime($row['due_date']) < strtotime(date('Y-m-d'));
                            $isClosed = (bool) $row['is_closed'];
                            $badgeClass = $isClosed ? 'danger' : 'success';
                            $badgeText = $isClosed ? 'Closed' : 'Open';
                            ?>
                            <tr>
                                <td class="align-middle text-left">
                                    <div class="font-weight-bold">
                                        <a
                                            href="<?= customUri('pis', 'Call for Submission Details', $row['id']) ?>"><?= e($row['title']) ?></a>
                                    </div>
                                    <span class="badge badge-secondary"><?= e($row['school_year']) ?></span>
                                    <span class="badge badge-<?= $badgeClass ?> ml-1"><?= $badgeText ?></span>
                                    <?php if (!$isClosed && $isOverdue): ?>
                                        <span class="badge badge-warning ml-1">Overdue</span>
                                    <?php endif; ?>
                                    <?php if (!empty($row['description'])): ?>
                                        <div class="small"><?= e($row['description']) ?></div>
                                    <?php endif ?>
                                </td>
                                <td class="align-middle small">
                                    <?= !empty($row['due_date']) ? toDate($row['due_date']) : '<span class="text-muted">No deadline</span>' ?>
                                </td>
                                <td class="align-middle">
                                    <a href="<?= customUri('pis', 'Call for Submission Details', $row['id']) ?>"
                                        class="badge badge-pill badge-<?= $subCount > 0 ? 'primary' : 'secondary' ?> px-2 py-1"
                                        title="View submissions">
                                        <?= $subCount ?>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php linkDropdownItem(
                                                customUri('pis', 'Call for Submission Details', $row['id']),
                                                'View',
                                                'fa-eye'
                                            );
                                            modalDropdownItem(
                                                uri() . '/modules/call-for-submission/save-call-for-submission-dialog.php?id=' . cipher($row['id']),
                                                'Edit',
                                                'fa-pencil-alt'
                                            ) ?>
                                            <div class="dropdown-divider"></div>
                                            <?php
                                            if ($isOverdue) {
                                                if (!$isClosed) {
                                                    modalDropDownItem(
                                                        uri() . '/modules/call-for-submission/close-call-for-submission-dialog.php?id=' . cipher($row['id']),
                                                        'Close',
                                                        'fa-times-circle',
                                                        'Close Call for Submission'
                                                    );
                                                } else {
                                                    modalDropDownItem(
                                                        uri() . '/modules/call-for-submission/reopen-call-for-submission-dialog.php?id=' . cipher($row['id']),
                                                        'Reopen',
                                                        'fa-folder-open',
                                                        'Reopen Call for Submission'
                                                    );
                                                }
                                            }
                                            modalDropdownItem(
                                                uri() . '/modules/call-for-submission/delete-call-for-submission-dialog.php?id=' . cipher($row['id']),
                                                'Delete',
                                                'fa-trash-alt',
                                                'Delete Call for Submission'
                                            ); ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr class="small">
                            <th class="align-middle text-left">Title / School Year / Description</th>
                            <th class="align-middle">Due</th>
                            <th class="align-middle">Submissions</th>
                            <th class="align-middle">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php endif ?>
    </div>
</div>