<?php
// modules/employees/tabs/educational-background.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'educational-background', 'show active') ?>"
    id="educational-background">
    <?php if ($editMode): ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/employees/save/save-education-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Education', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="10%">Level</th>
                        <th class="align-middle" width="25%">Name of School</th>
                        <th class="align-middle" width="25%">Basic Education / Degree / Course</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="10%">Highest Level / Units Earned</th>
                        <th class="align-middle" width="5%">Year Graduated</th>
                        <th class="align-middle" width="15%">Scholarship / Academic Honors Received</th>
                        <?php if ($editMode): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $educationalBackground = educationalBackgrounds($employeeId);

                    if ($educationalBackground) {
                        foreach ($educationalBackground as $education): ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= e($education['level']) ?></td>
                                <td class="align-middle"><?= e($education['school']) ?></td>
                                <td class="align-middle"><?= toHandleNull($education['course'], 'N/A') ?></td>
                                <td class="align-middle"><?= e($education['from_year']) ?></td>
                                <td class="align-middle">
                                    <?= $education['is_present'] ? 'PRESENT' : $education['to_year'] ?>
                                </td>
                                <td class="align-middle"><?= toHandleNull($education['highest_level'], 'N/A') ?></td>
                                <td class="align-middle"><?= toHandleNull($education['year_graduated'], 'N/A') ?></td>
                                <td class="align-middle"><?= toHandleNull($education['honors_received'], 'N/A') ?></td>
                                <?php if ($editMode): ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/employees/save/save-education-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($education['id']), 'Edit', 'fa-edit', 'Edit Education');
                                                modalDropdownItem(uri() . '/modules/employees/save/save-education-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($education['id']), 'Copy', 'fa-copy', 'Copy Education') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/employees/delete/delete-education-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($education['id']), 'Delete', 'fa-trash', 'Delete Education') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td colspan="<?= $editMode ? '9' : '8' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="10%">Level</th>
                        <th class="align-middle" width="25%">Name of School</th>
                        <th class="align-middle" width="25%">Basic Education / Degree / Course</th>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="10%">Highest Level / Units Earned</th>
                        <th class="align-middle" width="5%">Year Graduated</th>
                        <th class="align-middle" width="15%">Scholarship / Academic Honors Received</th>
                        <?php if ($editMode): ?>
                            <th class="align-middle" width="5%">Action</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>