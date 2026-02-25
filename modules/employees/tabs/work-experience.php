<?php
// modules/employees/tabs/work-experience.php
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'work-experience', 'show active') ?>"
    id="work-experience">
    <?php if ($editMode): ?>
        <div class="d-sm-flex justify-content-end my-3">
            <?php modalButtonSplit(uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId), 'Add', 'fa-plus', 'Add Work Experience', 'primary') ?>
        </div>
    <?php endif ?>

    <div class="row my-3">
        <div class="col table-responsive">
            <table width="100%" class="table table-striped table-bordered table-hover mb-0 text-center">
                <thead>
                    <tr>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="18%">Position Title</th>
                        <th class="align-middle" width="27%">Department / Agency / Office / Company</th>
                        <th class="align-middle" width="10%">Monthly Salary</th>
                        <th class="align-middle" width="10%">Salary / Job / Pay Grade &amp; Step Increment</th>
                        <th class="align-middle" width="10%">Status of Appointment</th>
                        <th class="align-middle" width="10%">Government Service</th>
                        <?php if ($editMode): ?>
                            <th class="align-middle" width="5%">Actions</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $experiences = experiences($employeeId);

                    if ($experiences) {
                        foreach ($experiences as $experience): ?>
                            <tr class="text-uppercase">
                                <td class="align-middle"><?= toDate($experience['from_date']) ?></td>
                                <td class="align-middle">
                                    <?= $experience['is_present'] ? 'PRESENT' : toDate($experience['to_date']) ?>
                                </td>
                                <td class="align-middle"><?= $experience['designation'] ?></td>
                                <td class="align-middle"><?= $experience['agency_company'] ?></td>
                                <td class="align-middle">
                                    <?= !empty($experience['monthly_salary']) ? toCurrency($experience['monthly_salary']) : 'N/A' ?>
                                </td>
                                <td class="align-middle"><?= $experience['salary_grade_step_increment'] ?></td>
                                <td class="align-middle"><?= $experience['appointment_status'] ?></td>
                                <td class="align-middle"><?= (bool) $experience['is_government_service'] ? 'Y' : 'N' ?>
                                </td>
                                <?php if ($editMode): ?>
                                    <td class="align-middle text-capitalize">
                                        <div class="dropdown no-arrow">
                                            <?php dropdownEllipsis() ?>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                                                <?php modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($experience['id']), 'Edit', 'fa-edit', 'Edit Service Record');
                                                modalDropdownItem(uri() . '/modules/service-record/save-service-record-dialog.php?c=' . cipher($employeeId) . '&e=' . cipher($employeeId) . '&id=' . cipher($experience['id']), 'Copy', 'fa-copy', 'Copy Service Record') ?>
                                                <div class="dropdown-divider"></div>
                                                <?php modalDropdownItem(uri() . '/modules/service-record/delete-service-record-dialog.php?e=' . cipher($employeeId) . '&id=' . cipher($experience['id']), 'Delete', 'fa-trash', 'Delete Service Record') ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td colspan="<?= $editMode ? '8' : '7' ?>" class="align-middle">No data available in table</td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="align-middle" width="5%">From</th>
                        <th class="align-middle" width="5%">To</th>
                        <th class="align-middle" width="18%">Position Title</th>
                        <th class="align-middle" width="27%">Department / Agency / Office / Company</th>
                        <th class="align-middle" width="10%">Monthly Salary</th>
                        <th class="align-middle" width="10%">Salary / Job / Pay Grade &amp; Step Increment</th>
                        <th class="align-middle" width="10%">Status of Appointment</th>
                        <th class="align-middle" width="10%">Government Service</th>
                        <?php if ($editMode): ?>
                            <th class="align-middle" width="5%">Actions</th>
                        <?php endif ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>