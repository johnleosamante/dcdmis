<?php
// modules/employees/tabs/recognition.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'recognition', 'show active') ?>"
    id="recognition">
    <?php if ($editMode): ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-recognition-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Recogntion', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="90%">Non-Academic Distinctions / Recognition</th>
                        <?php if ($editMode): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $recognitions = recognitions($employee['id']);
                    $raceAwards = employeeAwardedRecognitions($employee['id']);

                    if (!empty($recognitions) || !empty($raceAwards)) {
                        if (!empty($recognitions)) {
                            foreach ($recognitions as $recognition): ?>
                                <tr class="text-uppercase">
                                    <td class="align-middle"><?= e($recognition['title']) ?></td>
                                    <?php if ($editMode): ?>
                                        <td class="align-middle text-capitalize">
                                            <div class="dropdown no-arrow">
                                                <?php dropdownEllipsis() ?>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                    <?php modalDropdownItem(uri() . '/modules/employees/save/save-recognition-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($recognition['id']), 'Edit', 'fa-edit', 'Edit Recognition');
                                                    modalDropdownItem(uri() . '/modules/employees/save/save-recognition-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($recognition['id']), 'Copy', 'fa-copy', 'Copy Recognition') ?>
                                                    <div class="dropdown-divider"></div>
                                                    <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-recognition-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($recognition['id']), 'Delete', 'fa-trash', 'Delete Recognition') ?>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach;
                        }
                        if (!empty($raceAwards)) {
                            foreach ($raceAwards as $raceAward):
                                $raceUrl = customUri('race', 'Event Schedules') . '&schedule_id=' . cipher($raceAward['schedule_id']) . '&award_id=' . cipher($raceAward['award_id']);
                                ?>
                                <tr class="text-uppercase">
                                    <td class="align-middle"><?= e($raceAward['award_name']) ?>
                                        (<?= e($raceAward['schedule_title']) ?>)
                                    </td>
                                    <?php if ($editMode): ?>
                                        <td class="align-middle text-capitalize">
                                            <span class="badge badge-light border text-muted px-2 py-1 text-xs"
                                                title="Managed by Rewards & Recognition System">
                                                <i class="fas fa-lock mr-1"></i>
                                            </span>
                                        </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach;
                        }
                    } else { ?>
                        <tr>
                            <td colspan="<?= $editMode ? '2' : '1' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="90%">Non-Academic Distinctions / Recognition</th>
                        <?php if ($editMode): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>