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
                <?php if ($isHrmpsb): ?>
                    <div class="d-inline-block ml-2">
                        <?php linkButtonSplit(customUri('hrmpsb', 'Publish Vacancies'), 'Publish', 'fa-newspaper', 'Publish Vacancies', 'success') ?>
                    </div>
                <?php endif; ?>

                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'vacancies'), 'Export', 'fa-file-excel', 'Export as Excel file', $isHrmis ? 'success' : 'warning') ?>
                </div>
            </div>
        <?php } ?>

        <!-- Position Category Filter -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="category-filter" class="small font-weight-bold text-uppercase">Filter by Category</label>
                <select id="category-filter" class="form-control" onchange="filterByCategory(this.value)">
                    <option value="">All Categories</option>
                    <?php
                    $categories = positionCategories();
                    while ($category = fetchAssoc($categories)): ?>
                        <option value="<?= $category['category'] ?>">
                            <?= $category['category'] ?>
                        </option>
                    <?php endwhile ?>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="10%">Category</th>
                        <th class="align-middle" width="8%">SG</th>
                        <th class="align-middle" width="12%">Item Number</th>
                        <th class="align-middle" width="20%">Station</th>
                        <th class="align-middle" width="15%">Date Vacated</th>
                        <th class="align-middle" width="10%">Published</th>
                        <?php if ($isHrmpsb): ?>
                            <th class="align-middle" width="10%">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 0;
                    $query = vacantItems(); // Use the more detailed query
                    while ($row = fetchArray($query)): ?>
                        <tr class="text-uppercase" data-category="<?= $row['category'] ?>">
                            <td class="align-middle"><?= ++$count ?></td>
                            <td class="align-middle"><?= $row['position'] ?></td>
                            <td class="align-middle"><?= $row['category'] ?></td>
                            <td class="align-middle"><?= $row['salary_grade'] ?></td>
                            <td class="align-middle">
                                <?= toHandleNull($row['item_number'], 'N/A') ?>
                            </td>
                            <td class="align-middle">
                                <?php if (empty($row['station_id'])) {
                                    echo '<span class="text-muted">TO BE DETERMINED</span>';
                                } else {
                                    $school = fetchAssoc(schoolById($row['station_id']));
                                    if ($school) {
                                        linkItem(customUri($activeApp, 'School Information', $row['station_id']), $school['name']);
                                    } else {
                                        echo '<span class="text-muted">Unknown</span>';
                                    }
                                } ?>
                            </td>
                            <td class="align-middle">
                                <?= toLongDate($row['date_vacated']) ?>
                            </td>
                            <td class="align-middle">
                                <?php if (!empty($row['publication_code'])): ?>
                                    <span class="badge badge-success"><?= $row['publication_code'] ?></span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Unpublished</span>
                                <?php endif; ?>
                            </td>
                            <?php if ($isHrmpsb): ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                            <?php
                                            modalDropdownItem(uri() . '/modules/vacancies/save-vacancy-dialog.php?id=' . cipher($row['id']), 'Edit', 'fa-edit', 'Edit Vacancy');
                                            modalDropdownItem(uri() . '/modules/vacancies/save-vacancy-dialog.php?c=' . cipher($row['id']) . '&id=' . cipher($row['id']), 'Copy', 'fa-copy', 'Copy Vacancy');
                                            modalDropdownItem(uri() . '/modules/vacancies/fill-vacancy-dialog.php?id=' . cipher($row['id']), 'Fill Vacancy', 'fa-user-plus', 'Assign Employee');
                                            modalDropdownItem(uri() . '/modules/vacancies/delete-vacancy-dialog.php?id=' . cipher($row['id']), 'Delete', 'fa-trash-alt', 'Delete Vacancy') ?>
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
                        <th class="align-middle" width="10%">Category</th>
                        <th class="align-middle" width="8%">SG</th>
                        <th class="align-middle" width="12%">Item Number</th>
                        <th class="align-middle" width="20%">Station</th>
                        <th class="align-middle" width="15%">Date Vacated</th>
                        <?php if ($isHrmpsb): ?>
                            <th class="align-middle" width="10%">Action</th>
                        <?php endif; ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    function filterByCategory(category) {
        const rows = document.querySelectorAll('#data-table tbody tr');
        rows.forEach(row => {
            if (category === '' || row.dataset.category === category) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>