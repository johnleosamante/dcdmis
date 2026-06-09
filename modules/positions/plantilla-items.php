<?php
// modules/plantilla/page.php
if (!($isHrmis && $isPersonnel) && !($isHrmis && $isICT)) {
    require_once(root() . '/modules/error/403.php');
    return;
}

require_once root() . '/includes/database/plantilla.php';
require_once root() . '/includes/database/position.php';
require_once root() . '/includes/database/school.php';

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Plantilla Items</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithModal('Plantilla Items', uri() . '/modules/positions/save-plantilla-item-dialog.php', 'Add', 'fa-plus') ?>
    </div>

    <div class="card-body">
        <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
            <div class="d-inline-block">
                <?php linkButtonSplit(customUri('export', 'plantilla-items'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="60%">Item Number / Position</th>
                        <th class="align-middle" width="25%">Station</th>
                        <th class="align-middle" width="10%">Status</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = plantillaItems();
                    foreach ($query as $row):
                        $vacantClass = $row['is_vacant'] ? 'badge-success' : 'badge-secondary';
                        $vacantText = $row['is_vacant'] ? 'Vacant' : 'Filled';
                        ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <div><?= e($row['item_number']) ?></div>
                                <div><?= e($row['official_title']) . ' (' . e($row['salary_grade']) . ')' ?></div>
                                <div>
                                    <span class="badge badge-info">
                                        <?= e($row['employment_status']) ?>
                                    </span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <?= e($row['station_name']) ?>
                            </td>
                            <td class="align-middle">
                                <span class="badge <?= $vacantClass ?> badge-pill"><?= $vacantText ?></span>
                                <?php if ($row['is_dissolve']): ?>
                                    <br />
                                    <span class="badge badge-danger badge-pill">Dissolved</span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle text-capitalize">
                                <div class="dropdown no-arrow">
                                    <?php dropdownEllipsis() ?>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                        <?php
                                        $isVacantItem = vacantItem($row['id']);
                                        if (!$isVacantItem && $row['is_vacant']) {
                                            modalDropdownItem(uri() . '/modules/positions/fill-employee-dialog.php?id=' . cipher($row['id']), 'Fill', 'fa-user-plus', 'Fill Employee Position'); ?>
                                            <div class="dropdown-divider"></div>
                                            <?php
                                        }
                                        if (!$isVacantItem) {
                                            modalDropdownItem(uri() . '/modules/positions/save-plantilla-item-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Plantilla Item');
                                        }
                                        modalDropdownItem(uri() . '/modules/positions/save-plantilla-item-dialog.php?c=' . cipher($row['id']) . '&id=' . cipher($row['id']), 'Copy', 'fa-copy', 'Copy Plantilla Item');
                                        if (!$isVacantItem) { ?>
                                            <div class="dropdown-divider"></div>
                                            <?php modalDropdownItem(uri() . '/modules/positions/delete-plantilla-item-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash-alt', 'Delete Plantilla Item');
                                        } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="60%">Item Number / Position</th>
                        <th class="align-middle" width="25%">Station</th>
                        <th class="align-middle" width="10%">Status</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>