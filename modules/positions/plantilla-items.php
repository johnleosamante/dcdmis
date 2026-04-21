<?php
// modules/plantilla/page.php
if (!$isHrmis || !$isPersonnel) {
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
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="30%">Item Number</th>
                        <th class="align-middle" width="25%">Position Title</th>
                        <th class="align-middle" width="25%">Station / School</th>
                        <th class="align-middle" width="10%">Status</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 0;
                    $query = plantillaItems();
                    foreach ($query as $row):
                        $count++;
                        $vacantClass = $row['is_vacant'] ? 'badge-success' : 'badge-secondary';
                        $vacantText = $row['is_vacant'] ? 'Vacant' : 'Filled';
                        ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= $count ?></td>
                            <td class="align-middle"><?= e($row['item_number']) ?></td>
                            <td class="align-middle">
                                <div><?= e($row['official_title']) ?></div>
                                <div><?= e('SG: ' . $row['salary_grade']) ?></div>
                                <div><span class="badge badge-info">
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
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="30%">Item Number</th>
                        <th class="align-middle" width="25%">Position Title</th>
                        <th class="align-middle" width="25%">Station / School</th>
                        <th class="align-middle" width="10%">Status</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>