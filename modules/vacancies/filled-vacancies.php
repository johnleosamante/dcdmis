<?php
// modules/vacancies/filled-vacancies.php

if (!$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Filled Vacancies</li>
        </ol>
    </nav>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Filled Vacancies') ?>
    </div>

    <div class="card-body">
        <?php if ($isHrmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'filled-vacancies'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="18%">Position</th>
                        <th class="align-middle" width="8%">Salary Grade</th>
                        <th class="align-middle" width="12%">Item Number</th>
                        <th class="align-middle" width="18%">Station</th>
                        <th class="align-middle" width="20%">Filled By</th>
                        <th class="align-middle" width="12%">Date Filled</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $count = 0;
                    $query = vacanciesByStatus('filled');
                    foreach ($query as $row): ?>
                        <tr class="text-uppercase">
                            <td class="align-middle">
                                <?= ++$count ?>
                            </td>
                            <td class="align-middle">
                                <?= e($row['position']) ?>
                            </td>
                            <td class="align-middle">
                                <?= e($row['salary_grade']) ?>
                            </td>
                            <td class="align-middle">
                                <?= toHandleNull($row['item_number'], 'N/A') ?>
                            </td>
                            <td class="align-middle">
                                <?php if (empty($row['station_id'])) {
                                    echo '<span class="text-muted">N/A</span>';
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
                                <?php if (!empty($row['filled_by'])) {
                                    $filledBy = fetchAssoc(employee($row['filled_by']));
                                    if ($filledBy) {
                                        $employeeName = toName($filledBy['lname'], $filledBy['fname'], $filledBy['mname'], $filledBy['ext'], true);
                                        if ($isHrmis) {
                                            linkItem(customUri('hrmis', 'Employee Information', $row['filled_by']), $employeeName);
                                        } else {
                                            modalItem(uri() . '/modules/users/user-info-dialog.php?id=' . cipher($row['filled_by']), $employeeName);
                                        }
                                    } else {
                                        echo '<span class="text-muted">Unknown</span>';
                                    }
                                } else {
                                    echo '<span class="text-muted">N/A</span>';
                                } ?>
                            </td>
                            <td class="align-middle">
                                <?= !empty($row['date_filled']) ? toLongDate($row['date_filled']) : '<span class="text-muted">N/A</span>' ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">#</th>
                        <th class="align-middle" width="18%">Position</th>
                        <th class="align-middle" width="8%">SG</th>
                        <th class="align-middle" width="12%">Item Number</th>
                        <th class="align-middle" width="18%">Station</th>
                        <th class="align-middle" width="20%">Filled By</th>
                        <th class="align-middle" width="12%">Date Filled</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>