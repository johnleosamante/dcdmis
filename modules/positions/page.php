<?php

$userPositionId = null;
if ($isPis) {
    if (!function_exists('position')) {
        require_once(root() . '/includes/database/position.php');
    }
    $userPosition = position($userId);
    $userPositionId = $userPosition['position_id'] ?? null;
}
$isAllowedHigherPosition = $isPis && (in_array($userPositionId, $allowedMonitoringPositions, true) || $isICT);
$isPersonnelOrICT = $isHrmis && ($isPersonnel || $isICT);

if (!$isPersonnelOrICT && !$isAllowedHigherPosition) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <?php if ($isPis): ?>
                <li class="breadcrumb-item"><a href="<?= customUri('pis', 'System Overview') ?>">System Overview</a></li>
                <li class="breadcrumb-item"><a
                        href="<?= customUri('pis', 'Recruitment, Selection and Placement') ?>">Recruitment, Selection and
                        Placement</a></li>
            <?php endif ?>
            <li class="breadcrumb-item active">Positions</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isPersonnelOrICT) {
            contentTitleWithModal('Positions', "{$baseUri}/modules/positions/save-position-dialog.php", 'Add', 'fa-plus');
        } else {
            contentTitle('Positions');
        } ?>
    </div>

    <div class="card-body">
        <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
            <div class="d-inline-block">
                <?php linkButtonSplit(customUri('export', 'positions'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="70%">Position</th>
                        <th class="align-middle" width="10%">Plantilla Items</th>
                        <th class="align-middle" width="10%">Filled</th>
                        <?php if ($isPersonnelOrICT): ?>
                            <th class="align-middle" width="10%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = positionItems();
                    foreach ($query as $row) { ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div><?= e($row['official_title']) . " (" . e($row['salary_grade']) . ")" ?></div>
                                <div class="small"><?= e($row['category']) ?></div>
                            </td>
                            <td class="align-middle text-capitalize"><?= $row['total_plantilla_items'] ?></td>
                            <td class="align-middle text-capitalize"><?= $row['filled_plantilla_items'] ?></td>
                            <?php if ($isPersonnelOrICT): ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php modalDropdownItem(uri() . '/modules/positions/save-position-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Position');
                                            modalDropdownItem(uri() . '/modules/positions/save-position-dialog.php?id=' . cipher($row['id']), 'Copy', 'fa-copy', 'Copy Position') ?>
                                            <div class="dropdown-divider"></div>
                                            <?php
                                            modalDropdownItem(uri() . '/modules/positions/delete-position-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash', 'Delete Position'); ?>
                                        </div>
                                    </div>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="70%">Position</th>
                        <th class="align-middle" width="10%">Plantilla Items</th>
                        <th class="align-middle" width="10%">Filled</th>
                        <?php if ($isPersonnelOrICT): ?>
                            <th class="align-middle" width="10%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>