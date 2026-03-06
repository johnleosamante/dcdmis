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
                        <?php linkButtonSplit(customUri('hrmis', 'Publish Vacancies'), 'Publish', 'fa-newspaper', 'Publish Vacancies', 'info') ?>
                    </div>
                <?php endif ?>
            </div>
        <?php } ?>

        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <label for="category-filter" class="small font-weight-bold text-uppercase mb-0">Filter by
                    Category</label>
            </div>
            <div class="col-md-4">
                <select id="category-filter" class="form-control" onchange="filterByCategory(this.value)">
                    <option value="">All Categories</option>
                    <?php
                    $categories = positionCategories();
                    foreach ($categories as $category): ?>
                        <option value="<?= e($category['category']) ?>">
                            <?= e($category['category']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="25%">Position / Salary Grade</th>
                        <th class="align-middle" width="10%">Category</th>
                        <th class="align-middle" width="35%">Station</th>
                        <th class="align-middle" width="15%">Date Vacated</th>
                        <th class="align-middle" width="10%">Publication Code</th>
                        <?php if ($isPersonnel): ?>
                            <th class="align-middle" width="10%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 0;
                    $query = vacantItems();
                    if ($query) {
                        foreach ($query as $row): ?>
                            <tr class="text-uppercase" data-category="<?= e($row['category']) ?>">
                                <td class="align-middle"><?= ++$count ?></td>
                                <td class="align-middle">
                                    <div><?= $row['official_title'] . ' (' . $row['salary_grade'] . ')' ?></div>
                                    <?php if ($row['item_number']) {
                                        echo '<div class="badge badge-info small">' . $row['item_number'] . '</div>';
                                    } ?>
                                </td>
                                <td class="align-middle"><?= e($row['category']) ?></td>
                                <td class="align-middle">
                                    <?php $school = schoolById($row['station_id']);
                                    if ($school) {
                                        linkItem(customUri($activeApp, 'School Information', $row['station_id']), $school['name']);
                                    } else {
                                        echo '<span class="text-muted">TO BE DETERMINED</span>';
                                    } ?>
                                </td>
                                <td class="align-middle">
                                    <?= toLongDate($row['date_vacated']) ?>
                                </td>
                                <td class="align-middle">
                                    <?php if (!empty($row['publication_code'])): ?>
                                        <?php $isPublished = true; ?>
                                        <span class="badge badge-success"><?= e($row['publication_code']) ?></span>
                                    <?php else: ?>
                                        <?php $isPublished = false; ?>
                                        <span class="badge badge-secondary">Not Published</span>
                                    <?php endif ?>
                                </td>
                                <?php if ($isPersonnel): ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php
                                                modalDropdownItem(uri() . '/modules/vacancies/save-vacancy-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Vacancy');
                                                modalDropdownItem(uri() . '/modules/vacancies/save-vacancy-dialog.php?c=' . cipher($row['id']) . '&id=' . cipher($row['id']), 'Copy', 'fa-copy', 'Copy Vacancy');
                                                if ($isPublished) {
                                                    modalDropdownItem(uri() . '/modules/vacancies/fill-vacancy-dialog.php?id=' . cipher($row['id']), 'Fill Vacancy', 'fa-user-plus', 'Assign Employee');
                                                }
                                                modalDropdownItem(uri() . '/modules/vacancies/delete-vacancy-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash-alt', 'Delete Vacancy') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                        <tr id="no-data-row" style="display:none;">
                            <td colspan="9" class="text-center text-muted">No data available for the selected category.</td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">No data available in table.</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="25%">Position / Salary Grade</th>
                        <th class="align-middle" width="10%">Category</th>
                        <th class="align-middle" width="35%">Station</th>
                        <th class="align-middle" width="15%">Date Vacated</th>
                        <th class="align-middle" width="10%">Publication Code</th>
                        <?php if ($isPersonnel): ?>
                            <th class="align-middle" width="10%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    function filterByCategory(category) {
        const tbody = document.querySelector('#data-table tbody');
        const allRows = Array.from(tbody.querySelectorAll('tr'));
        const dataRows = allRows.filter(r => !r.id || r.id !== 'no-data-row');
        const noDataRow = tbody.querySelector('#no-data-row');

        let visibleCount = 0;
        dataRows.forEach(row => {
            if (category === '' || row.dataset.category === category) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noDataRow) {
            noDataRow.style.display = visibleCount === 0 ? '' : 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        filterByCategory(document.getElementById('category-filter').value);
    });
</script>