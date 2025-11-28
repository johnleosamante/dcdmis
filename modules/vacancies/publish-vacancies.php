<?php
// modules/vacancies/publish-vacancy.php

if (!$isHrmpsb && !$isHrmis) {
    require_once root() . '/modules/error/403.php';
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitleWithLink('Publish Vacancies', customUri('hrmpsb', 'Vacancies')) ?>
    </div>

    <div class="card-body">
        <form action="" method="POST">
            <div class="table-responsive my-3">
                <table class="table table-hover mb-0 text-center" id="data-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="3%"></th>
                            <th class="align-middle" width="20%">Position</th>
                            <th class="align-middle" width="10%">Item Number</th>
                            <th class="align-middle" width="20%">Station</th>
                            <th class="align-middle" width="20%">Remarks</th>
                            <th class="align-middle" width="15%">Posted On</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $result = vacancies();
                        while ($row = fetchArray($result)) : ?>
                            <tr class="text-uppercase">
                                <td class="align-middle">
                                    <input type="checkbox" class="form-control" name="vacancies[]" value="<?= cipher($row['id']) ?>">
                                </td>
                                <td class="align-middle"><?= $row['position'] ?></td>
                                <td class="align-middle"><?= toHandleNull($row['psipop'], 'N/A') ?></td>
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
                            </tr>
                        <?php endwhile ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th width="3%"></th>
                            <th class="align-middle" width="20%">Position</th>
                            <th class="align-middle" width="10%">Item Number</th>
                            <th class="align-middle" width="20%">Station</th>
                            <th class="align-middle" width="20%">Remarks</th>
                            <th class="align-middle" width="15%">Posted On</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button class="btn btn-primary btn-block" name="publish-vacancies">
                <i class="fas fa-plus fa-fw"></i>
                Publish Vacancies
            </button>
        </form>
    </div>
</div>