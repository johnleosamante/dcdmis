<?php

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
        <?php contentTitle('Vacancies') ?>
    </div>

    <div class="card-body">
        <?php if ($isDmis) { ?>
            <div class="d-sm-flex align-items-center flex-row-reverse mb-2">
                <div class="d-inline-block">
                    <?php linkButtonSplit(customUri('export', 'users'), 'Export', 'fa-file-excel', 'Export as Excel file', 'success') ?>
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
                            <td class="align-middle"><?= $row['psipop'] ?></td>
                            <td class="align-middle"><?= fetchAssoc(schoolById($row['station_id']))['name'] ?></td>
                            <td class="align-middle">
                                <?php if (!empty($row['employee_id'])) : ?>
                                    <?php $vice = fetchAssoc(employee($row['employee_id'])); ?>
                                    <div>VICE: <?= toName($vice['lname'], $vice['fname'], $vice['mname'], $vice['ext'], true) ?></div>
                                <?php endif; ?>
                                <div><?= $row['reason'] ?></div>
                            </td>
                            <td class="align-middle"><?= toLongDate($row['date_vacated']) ?></td>
                            <?php if ($isHrmpsb) : ?>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">Photo</th>
                        <th class="align-middle" width="20%">Name</th>
                        <th class="align-middle" width="15%">Email Address</th>
                        <th class="align-middle" width="20%">Position</th>
                        <th class="align-middle" width="25%">Station</th>
                        <th class="align-middle" width="10%">Status</th>
                        <?php if ($isHrmpsb) : ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif; ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>