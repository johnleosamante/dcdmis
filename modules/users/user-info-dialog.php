<?php
// modules/users/user-info-dialog.php
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
    $picture = file_exists(root() . '/' . $employee['profile_picture']) ? uri() . '/' . $employee['profile_picture'] : uri() . '/assets/img/user.png';
    $modalTitle = 'Employee Information';
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
                } else {
                    missingAlert($modalTitle);
                } ?>
            </div>

            <div class="modal-footer">
                <?php cancelModalButton() ?>
            </div>
        </form>
    </div>
</div>