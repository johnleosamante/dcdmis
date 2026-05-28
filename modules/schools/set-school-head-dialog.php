<?php
// modules/schools/assign-school-head-dialog.php
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
    $doa = $positions['date'];
    $stationId = $positions['station_id'];
    $station = $positions['station'];
    $positionId = $positions['position_id'];
    $position = $positions['position'];
    $depedEmail = $employee['email'];
    $picture = "$baseUri/" . $employee['picture'];
    $modalTitle = 'Set Head of Office';
    $hasEmployee = true;
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
                } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="verifier" value="<?= $_GET['id'] ?? null ?>">
                <input type="hidden" name="data-verifier" value="<?= $_GET['e'] ?? null ?>">
                <button class="btn btn-primary" name="set-school-head" type="submit">Continue</button>
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>