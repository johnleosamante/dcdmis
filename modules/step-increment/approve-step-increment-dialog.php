<?php
// modules/step-increment/approve-step-increment-dialog.php
require_once('../../includes/function.php');
require_once(root() . '/includes/database/database.php');
require_once(root() . '/includes/database/employee.php');
require_once(root() . '/includes/database/position.php');
require_once(root() . '/includes/database/school.php');
require_once(root() . '/includes/layout/components.php');
require_once(root() . '/includes/string.php');

$employeeId = isset($_GET['id']) ? sanitize(decipher($_GET['id'])) : null;
$employee = employee($employeeId);
$modalTitle = 'Employee not found';
$hasEmployee = false;

if ($employee) {
    $employeeId = $employee['id'];
    $employeeName = toName($employee['last_name'], $employee['first_name'], $employee['middle_name'], $employee['name_extension'], true);
    $sex = $employee['sex'];
    $status = $employee['status'];
    $position = position($employeeId);
    $stationId = $position['station_id'];
    $station = $position['station'];
    $positionId = $position['position_id'];
    $position = $position['official_title'];
    $depedEmail = $employee['email_address'];
    $picture = file_exists(root() . '/' . $employee['profile_picture']) ? "{$baseUri}/" . $employee['profile_picture'] : "{$baseUri}/assets/img/user.png";
    $modalTitle = 'Approve Employee Step Increment';
    $hasEmployee = true;
}
?>

<div class="modal-dialog <?= !$hasEmployee ? 'modal-sm' : '' ?>">
    <div class="modal-content">
        <?php modalHeader($modalTitle) ?>

        <form action="" method="POST">
            <div class="modal-body">
                <?php if ($hasEmployee) {
                    employeeProfile($picture, $employeeName, $sex, $depedEmail, $position, $station, $status);
                    ?>
                    <hr>

                    This operation will approve the step increment of this employee. Are you sure you want to continue?
                <?php } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php if ($hasEmployee): ?>
                    <input type="hidden" name="verifier" value="<?= $_GET['id'] ?>">
                    <button class="btn btn-success" name="approve-step-increment" type="submit">Yes, Continue</button>
                <?php endif;

                cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>