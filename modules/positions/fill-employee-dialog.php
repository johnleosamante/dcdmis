<?php
// modules/positions/fill-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/plantilla.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$plantillaItemId = sanitize(decipher($_GET['id']));
$plantilla = $plantillaItemId ? plantillaItem($plantillaItemId) : null;

if (!$plantilla) { ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <?php modalHeader('Fill Employee Position') ?>
            <div class="modal-body">
                <?php missingAlert('Plantilla item not found.') ?>
            </div>
            <div class="modal-footer">
                <?php cancelModalButton() ?>
            </div>
        </div>
    </div>
    <?php
    return;
}

$positionDetail = itemPosition($plantillaItemId);
$positionTitle = $positionDetail['official_title'] ?? 'Unknown Position';
$itemNumber = $positionDetail['item_number'] ?? 'N/A';
$stationId = $plantilla['station_id'];
$stationInfo = schoolById($stationId);
$stationName = $stationInfo['name'] ?? 'Unknown Station';
$employmentStatus = $plantilla['employment_status'];
$positionId = $plantilla['position_id'];
$employees = employeesByStation($stationId, $positionId);
?>

<div class="modal-dialog">
    <div class="modal-content">
        <?php modalHeader('Fill Employee Position') ?>

        <form method="POST" action="" id="fill-employee-form">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if (empty($employees)): ?>
                    <div class="p-2 rounded alert-warning text-left d-flex">
                        <span class="d-inline-block">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <span class="ml-2 d-inline-block d-flex align-items-center small">
                            <div>No active employees at <strong class="text-uppercase"><?= e($stationName) ?></strong>
                                are currently assigned to the <strong
                                    class="text-uppercase"><?= e($positionTitle) ?></strong> position.
                                Only employees whose station assignment matches this position are eligible to fill it.
                            </div>
                        </span>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3 p-2 rounded alert-info text-left d-flex">
                                <span class="d-inline-block">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <span class="ml-2 d-inline-block d-flex align-items-center small">
                                    <div>Filling position <strong class="text-uppercase">
                                            <?= e($positionTitle) ?>
                                        </strong>
                                        <br>Item No. <strong>
                                            <?= e($itemNumber) ?>
                                        </strong>
                                        at <strong class="text-uppercase">
                                            <?= e($stationName) ?>
                                        </strong>.
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fill-employee-select" class="mb-1 font-weight-bold">
                            Select Employee <?php showAsterisk() ?>
                        </label>
                        <select id="fill-employee-select" name="employee_id" class="form-control" required
                            onchange="updateAssignmentDate(this)">
                            <option value="">Select employee...</option>
                            <?php foreach ($employees as $emp):
                                $fullName = strtoupper(toName($emp['last_name'], $emp['first_name'], $emp['middle_name'], $emp['name_extension'], true));
                                $assignDate = $emp['assignment_date'] ?? date('Y-m-d');
                                ?>
                                <option value="<?= e($emp['id']) ?>">
                                    <?= e($fullName) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fill-start-date" class="mb-1 font-weight-bold">
                            Start Date <?php showAsterisk() ?>
                        </label>
                        <input type="date" id="fill-start-date" name="start_date" class="form-control"
                            value="<?= date('Y-m-d', strtotime($assignDate)) ?>" required>
                    </div>

                    <?php requiredLegend(0) ?>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= e($_GET['id'] ?? '') ?>">
                <?php if (!empty($employees)): ?>
                    <button class="btn btn-primary" name="fill-plantilla-employee" type="submit">Continue</button>
                <?php endif; ?>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>