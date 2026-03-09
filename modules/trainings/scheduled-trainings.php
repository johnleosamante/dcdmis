<?php
// modules/trainings/scheduled-trainings.php
if (!$isHrtdms) {
    require_once(root() . '/modules/error/403.php');
    return;
}

messageAlert($showAlert, $message, $success);
?>

<div class="d-flex align-items-center justify-content-between flex-row mt-2 mb-3">
    <nav class="d-flex align-items-center flex-row m-0">
        <ol class="breadcrumb m-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="<?= uri() . '/' . $activeApp ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Scheduled Trainings</li>
        </ol>
    </nav>

    <div class="d-inline-block">
        <?php modalButtonSplit(uri() . '/modules/trainings/save-training-dialog.php', 'Add Training', 'fa-plus') ?>
    </div>
</div>

<div class="card border-left-primary shadow mb-4">
    <div class="card-header py-3">
        <?php contentTitle('Scheduled Trainings') ?>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mb-0 text-center" id="data-table" width="100%"
                cellspacing="0">
                <thead>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="30%">Title of Learning &amp; Development Interventions /
                            Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="15%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="25%">Conducted / Sponsored by</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $trainings = scheduledTrainings();
                    if ($trainings) {
                        foreach ($trainings as $training): ?>
                            <tr class="text-uppercase">
                                <td class="align-middle">
                                    <?php linkItem(customUri('hrtdms', 'Training Details', $training['id']), $training['id']) ?>
                                </td>
                                <td class="align-middle text-left"><?= e($training['title']) ?></td>
                                <td class="align-middle"><?= toDate($training['start_date']) ?></td>
                                <td class="align-middle"><?= toDate($training['end_date']) ?></td>
                                <td class="align-middle"><?= trainingType($training['training_type_id']) ?></td>
                                <td class="align-middle"><?= e($training['sponsored_by']) ?></td>
                                <td class="align-middle text-capitalize">
                                    <div class="dropdown no-arrow">
                                        <?php dropdownEllipsis() ?>
                                        <div class="dropdown-menu dropdown-menu-righ shadow animated--fade-in">
                                            <?php linkDropdownItem(customUri('hrtdms', 'Training Details', $training['id']), 'View', 'fa-eye', 'View Training');
                                            modalDropdownItem(uri() . '/modules/trainings/save-training-dialog.php?id=' . cipher($training['id']), 'Edit', 'fa-edit', 'Edit Training') ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    }
                    ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="15%">Code</th>
                        <th class="align-middle" width="30%">Title of Learning &amp; Development Interventions /
                            Training Programs</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="15%">Type of Learning &amp; Development</th>
                        <th class="align-middle" width="25%">Conducted / Sponsored by</th>
                        <th class="align-middle" width="5%">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>