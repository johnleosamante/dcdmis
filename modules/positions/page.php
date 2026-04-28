<?php

if (!$isHrmis) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Positions</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithModal('Positions', "{$baseUri}/modules/positions/save-position-dialog.php", 'Add', 'fa-plus'); ?>
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
                        <th class="align-middle" width="95%">Position</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = positions();
                    foreach ($query as $row) { ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div><?= e($row['official_title']) . " (SG " . e($row['salary_grade']) . ")" ?></div>
                                <div class="small"><?= e($row['category']) ?></div>
                            </td>
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
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="95%">Position</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>