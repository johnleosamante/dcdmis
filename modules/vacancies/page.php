<?php
// modules/vacancies/page.php
if (!$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= "{$baseUri}/{$activeApp}" ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Vacancies</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php if ($isPersonnel) {
            contentTitleWithModal('Vacancies', "{$baseUri}/modules/vacancies/save-vacancy-dialog.php", 'Add', 'fa-plus');
        } else {
            contentTitle('Vacancies');
        } ?>
    </div>

    <div class="card-body">
        <?php if ($isDmis || $isHrmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block ml-2">
                    <?php linkButtonSplit(customUri('export', 'vacancies'), 'Export', 'fa-file-excel', 'Export as Excel file', $isHrmis ? 'success' : 'warning') ?>
                </div>

                <?php if ($isPersonnel): ?>
                    <div class="d-inline-block">
                        <?php linkButtonSplit(customUri('hrmis', 'Create Call for Application'), 'Create Call for Application', 'fa-bullhorn', 'Create Call for Application', 'info') ?>
                    </div>
                <?php endif ?>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" width="100%" cellspacing="0" id="data-table">
                <thead>
                    <tr>
                        <th class="align-middle" width="30%">Position / Salary Grade / Item Number</th>
                        <th class="align-middle" width="15%">Category</th>
                        <th class="align-middle" width="40%">Station</th>
                        <th class="align-middle" width="15%">Date Vacated / Posted</th>
                        <?php if ($isPersonnel): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = vacantItems();
                    foreach ($query as $row): ?>
                        <tr class="text-uppercase" data-category="<?= e($row['category']) ?>">
                            <td class="align-middle">
                                <div><?= $row['official_title'] . ' (' . $row['salary_grade'] . ')' ?></div>
                                <?php if ($row['item_number']) {
                                    echo '<div class="badge badge-info badge-pill small">' . $row['item_number'] . '</div>';
                                } ?>
                            </td>
                            <td class="align-middle"><?= e($row['category']) ?></td>
                            <td class="align-middle">
                                <?php $school = schoolById($row['station_id']);
                                linkItem(customUri($activeApp, 'School Information', $row['station_id']), $school['name']); ?>
                            </td>
                            <td class="align-middle">
                                <?= toLongDate($row['date_vacated']) ?>
                            </td>
                            <?php if ($isPersonnel): ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php modalDropdownItem(uri() . '/modules/vacancies/delete-vacancy-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash-alt', 'Delete Vacancy') ?>
                                        </div>
                                    </div>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="30%">Position / Salary Grade / Item Number</th>
                        <th class="align-middle" width="15%">Category</th>
                        <th class="align-middle" width="40%">Station</th>
                        <th class="align-middle" width="15%">Date Vacated / Posted</th>
                        <?php if ($isPersonnel): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>