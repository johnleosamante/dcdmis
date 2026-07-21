<?php
// modules/employees/remove-employee-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/plantilla.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = sanitize(decipher($_GET['id'] ?? null));
$employee = employee((int) $employeeId);
$modalTitle = 'Employee not found';
$hasEmployee = false;
$itemNumber = null;

if ($employee) {
    $employeeId = $employee['id'];
    $employeeName = toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'], true);
    $sex = $employee['sex'];
    $status = $employee['status'];
    $positions = position($employeeId);
    $stationId = $positions['station_id'];
    $station = $positions['station'];
    $positionId = $positions['position_id'];
    $position = $positions['official_title'];
    $depedEmail = $employee['email_address'];
    $picture = file_exists(root() . '/' . $employee['profile_picture']) ? "{$baseUri}/" . $employee['profile_picture'] : "{$baseUri}/assets/img/user.png";
    $modalTitle = 'Remove Employee';
    $hasEmployee = true;
    $employeeItem = employeeItemNumber($employeeId);

    if ($employeeItem) {
        $itemNumber = $employeeItem['item_number'] ?? null;
    }
}
?>

<div class="modal-dialog <?= !$hasEmployee ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>
        <form action="" method="POST">
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if ($hasEmployee) {
                    employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station, $status);
                    ?>
                    <hr>
                    <div class="form-group">
                        <label for="reason" class="mb-0">Reason <?php showAsterisk() ?></label>
                        <select id="reason" name="reason" class="form-control" title="Select reason of removal..." required>
                            <option value="">Select reason...</option>
                            <option value="Transferred">Transferred</option>
                            <option value="Resigned">Resigned</option>
                            <option value="Retired">Retired</option>
                            <option value="Suspended">Suspended</option>
                            <option value="Dismissed">Dismissed</option>
                            <option value="Deceased">Deceased</option>
                            <option value="Duplicate">Duplicate</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="effectivity-date" class="mb-0">Date of Effectivity / Separation <?php showAsterisk() ?></label>
                        <input class="form-control" type="date" id="effectivity-date" name="effectivity_date"
                            value="<?= date('Y-m-d') ?>" title="Set date of effectivity..." required>
                    </div>

                    <div class="form-group mb-2" id="vacancy-option">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="skip-vacancy" name="skip_vacancy"
                                value="1">
                            <label class="custom-control-label" for="skip-vacancy">
                                <strong>Do not create vacancy</strong>
                                <small class="d-block text-muted">Check this if the position does not require creation of a
                                    vacant
                                    item</small>
                            </label>
                        </div>
                    </div>

                    <?php if ($itemNumber): ?>
                        <div class="alert alert-info p-2 my-2 small d-flex align-items-start">
                            <i class="fas fa-info-circle mt-1 mr-1"></i>
                            <div>
                                Item Number: <strong><?= e($itemNumber) ?>
                                </strong> will be marked as vacant unless you check the
                                option above or is duplicate employee.
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php requiredLegend(0) ?>
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasEmployee): ?>
                    <input type="hidden" name="verifier" value="<?= e($_GET['id']) ?>">
                    <button class="btn btn-danger" name="remove-employee" type="submit">Continue</button>
                <?php endif;

                cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>