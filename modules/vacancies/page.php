<?php
// modules/vacancies/page.php
if (!$isHrmis && !$isHrmpsb) {
    require_once root() . '/modules/error/403.php';
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Vacancies</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if (!$isHrmpsb) {
            contentTitle('Vacancies');
        } else {
            contentTitleWithModal('Vacancies', uri() . '/modules/vacancies/save-vacancy-dialog.php', 'Add Vacancy', 'fa-plus');
        } ?>
    </div>

    <div class="card-body">
        <?php if ($isDmis || $isHrmpsb || $isHrmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <?php if ($isHrmpsb) : ?>
                    <div class="d-inline-block ml-2">
                        <?php linkButtonSplit(customUri('hrmpsb', 'Publish Vacancies'), 'Publish', 'fa-newspaper', 'Publish Vacancies', 'success') ?>
                    </div>
                <?php endif; ?>

                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'vacancies'), 'Export', 'fa-file-excel', 'Export as Excel file', $isHrmis ? 'success' :  'warning') ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="10%">Item Number</th>
                        <th class="align-middle" width="20%">Station</th>
                        <th class="align-middle" width="20%">Remarks</th>
                        <th class="align-middle" width="15%">Posted On</th>
                        <?php if ($isHrmpsb) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 0;
                    $query = vacancies();
                    while ($row = fetchArray($query)) : ?>
                        <tr class="text-uppercase">
                            <td class="align-middle"><?= ++$count ?></td>
                            <td class="align-middle"><?= $row['position'] ?></td>
                            <td class="align-middle">
                                <?= toHandleNull($row['psipop'], 'N/A') ?>
                            </td>
                            <td class="align-middle">
                                <?php if (empty($row['station_id'])) {
                                    echo 'TO BE DETERMINED';
                                } else {
                                    linkItem(customUri($activeApp, 'School Information', $row['station_id']), fetchAssoc(schoolById($row['station_id']))['name']);
                                } ?>
                            </td>
                            <td class="align-middle">
                                <?php if (!empty($row['employee_id'])) : ?>
                                    <?php $vice = fetchAssoc(employee($row['employee_id'])); ?>
                                    <div>VICE: <?php
                                                $employeeName = toName($vice['lname'], $vice['fname'], $vice['mname'], $vice['ext'], true);
                                                if (!$isHrmis) {
                                                    modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['employee_id']), $employeeName);
                                                } else {
                                                    linkItem(customUri('hrmis', 'Employee Information', $row['employee_id']), $employeeName);
                                                }
                                                ?>
                                    </div>
                                <?php endif;

                                $isNewItem = strtolower($row['reason']) === 'new'; ?>

                                <?= $isNewItem ? roundPill($row['reason'], 'success') : $row['reason'] ?>
                            </td>
                            <td class="align-middle">
                                <?= toLongDate($row['date_vacated']) ?>
                            </td>
                            <?php if ($isHrmpsb) : ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php
                                            modalDropdownItem(uri() . '/modules/vacancies/save-vacancy-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Vacancy');
                                            modalDropdownItem(uri() . '/modules/vacancies/save-vacancy-dialog.php?c=' . cipher($row['id']) . '&id=' . cipher($row['id']), 'Copy', 'fa-copy', 'Copy Vacancy') ?>
                                        </div>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="10%">Item Number</th>
                        <th class="align-middle" width="20%">Station</th>
                        <th class="align-middle" width="20%">Remarks</th>
                        <th class="align-middle" width="15%">Posted On</th>
                        <?php if ($isHrmpsb) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif; ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>